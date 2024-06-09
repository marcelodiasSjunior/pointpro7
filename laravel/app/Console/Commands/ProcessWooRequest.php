<?php

namespace App\Console\Commands;

use App\Http\Services\CityService;
use App\Models\Company;
use App\Models\User;
use App\Models\UserCompany;
use App\Models\WooOrderItem;
use App\Models\WooRequest;
use App\Models\WPUser;
use App\Models\WPUserMeta;
use App\Notifications\CompanyCreated;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class ProcessWooRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-woo-request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $last_10_request_updated = WooRequest::where('type', 'woocommerce_membership_updated')->take(10)->get();

        foreach ($last_10_request_updated as $req) {
            $payload = JSON_DECODE($req->payload);
            if ($payload && $payload->user_id) {
                $this->createOrUpdatePlace($payload->user_id);
            }
            $req->delete();
        }
        return 0;
    }

    private function createOrUpdatePlace($wp_user_id)
    {
        $wp_user_id = (int)$wp_user_id;
        $WPUser = WPUser::where('ID', $wp_user_id)->first();

        if (!$WPUser) {
            return;
        }


        $WPUserMeta = WPUserMeta::where('user_id', $wp_user_id)->get();

        $hasSubscription = false;
        foreach ($WPUserMeta as $meta) {
            switch ($meta->meta_key) {
                case 'billing_cnpj';
                    $hasSubscription = true;
                    break;
            }
        }
        $user = User::where('email', $WPUser->user_email)->first();

        if ($hasSubscription && !$user) {

            $password = Str::random(10);
            $passwordHash = bcrypt($password);

            $user = User::create([
                'name' => $WPUser->display_name,
                'email' => $WPUser->user_email,
                'password' => $passwordHash,
                'role' => 2,
                'wp_user_id' => $wp_user_id
            ]);


            $company = new Company();

            foreach ($WPUserMeta as $meta) {
                switch ($meta->meta_key) {
                    case '_wcs_subscription_ids_cache':
                        $subId = unserialize($meta->meta_value);
                        if (isset($subId) && is_array($subId)) {
                            $plan = WooOrderItem::where('order_id', $subId[0])->orderBy('order_item_id', 'DESC')->first();
                            if ($plan) {
                                if (str_contains($plan->order_item_name, 'Parceiro')) {
                                    $company->plan = 1;
                                } else  if (str_contains($plan->order_item_name, 'Especial')) {
                                    $company->plan = 2;
                                }
                            }
                        }
                        break;
                    case 'billing_nome_fastasia';
                        $company->razao_social =  $meta->meta_value;
                        $company->save();
                        break;
                    case 'billing_seguimento';
                        $company->seguimento =  $meta->meta_value;
                        $company->save();
                        break;
                    case 'billing_phone';
                        $company->telefone =  $meta->meta_value;
                        $company->save();
                        break;
                    case 'billing_company';
                        $company->title =  $meta->meta_value;
                        $company->save();
                        break;
                    case 'billing_address_1';
                        $company->endereco =  $meta->meta_value;
                        $company->save();
                        break;
                    case 'billing_city';
                        $city = CityService::getCityByName($meta->meta_value);

                        if ($city) {
                            $company->city_id =  $city['id'];
                            $company->state_id =  $city['state_id'];
                            $company->save();
                        }
                        break;
                    case 'billing_neighborhood';
                        $company->bairro =  $meta->meta_value;
                        $company->save();
                        break;
                    case 'billing_number';
                        $company->numero =  $meta->meta_value;
                        $company->save();
                        break;
                    case 'billing_postcode';
                        $company->cep =  $meta->meta_value;
                        $company->save();
                        break;
                    case 'billing_cnpj';
                        $company->cnpj =  $meta->meta_value;
                        $company->save();
                        break;
                }
            }

            $company->save();

            UserCompany::create([
                'user_id' => $user->id,
                'company_id' => $company->id
            ]);


            Notification::send([$user], new CompanyCreated(["password" => $password, "email" => $user->email]));
        }

        // $media_uri = 'https://pointpro7.com/wp-content/uploads/';

        // $usermeta = WPUserMeta::where('user_id', $company->wp_user_id)->get();

        //         case '_wc_memberships_profile_field_logomarca_ou_foto';
        //             $media = WPPostMeta::where('meta_key', '_wp_attached_file')->where('post_id', $meta->meta_value)->first();
        //             $company->avatar =  $media_uri . $media->meta_value;
        //             $company->save();
        //             break;

    }
}
