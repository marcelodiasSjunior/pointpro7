<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Company;
use App\Models\Funcao;
use App\Models\Funcionario;
use App\Models\Jornada;
use App\Models\User;
use App\Models\UserCompany;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory()->create([
        //     'name' => 'Henrique',
        //     'email' => 'henrique_admin@henriqueadmin.com',
        //     'role' => 1,
        //     'password' => bcrypt('123#456@_')
        // ]);

        // User::factory()->create([
        //     'name' => 'Thiago Lovatine',
        //     'email' => 'thiagolovatine_admin@gmail.com',
        //     'role' => 1,
        //     'password' => bcrypt('123#456@_')
        // ]);

        // $user_company = User::factory()->create([
        //     'name' => 'Thiago Lovatine',
        //     'email' => 'thiagolovatine_empresa@gmail.com',
        //     'role' => 2,
        //     'password' => bcrypt('123#456@_')
        // ]);

        // User::factory()->create([
        //     'name' => 'Thiago Lovatine',
        //     'email' => 'thiagolovatine_funcionario@gmail.com',
        //     'role' => 3,
        //     'password' => bcrypt('123#456@_')
        // ]);

        // $user_company2 = User::factory()->create([
        //     'name' => 'Henrique Souza',
        //     'email' => 'henriquesouzaa_empresa@hotmail.com',
        //     'role' => 2,
        //     'password' => bcrypt('123#456@')
        // ]);

        // User::factory()->create([
        //     'name' => 'Henrique Souza',
        //     'email' => 'henriquesouzaa_funcionario@hotmail.com',
        //     'role' => 3,
        //     'password' => bcrypt('123#456@')
        // ]);

        // User::factory()->create([
        //     'name' => 'Henrique Souza',
        //     'email' => 'henriquesouzaa_admin@hotmail.com',
        //     'role' => 1,
        //     'password' => bcrypt('123#456@')
        // ]);

        // $company = Company::create([
        //     'title' => 'Rabbit Company',
        //     'logo' => 'https://pro7.nyc3.cdn.digitaloceanspaces.com/pictures/2/2_1692548195_mTzll6k9zYa6zUFCu8IK.jpg',
        //     'seguimento' => 'Entregas',
        //     'razao_social' => 'LOCALOIDERS',
        //     'cnpj' => '12.312.312/3123-12',
        //     'telefone' => '(12) 31231-2312',
        //     'cep' => '13140-693',
        //     'endereco' => 'Avenida José Pedro de Oliveira',
        //     'numero' => '871',
        //     'complemento' => 'LOJA C',
        //     'bairro' => 'Jardim América',
        //     'state_id' => '35',
        //     'city_id' => '3536505',
        // ]);

        // $company2 = Company::create([
        //     'title' => 'Rabbit Company',
        //     'logo' => 'https://pro7.nyc3.cdn.digitaloceanspaces.com/pictures/2/2_1692548195_mTzll6k9zYa6zUFCu8IK.jpg',
        //     'seguimento' => 'Entregas',
        //     'razao_social' => 'LOCALOIDERS',
        //     'cnpj' => '12.312.312/3123-12',
        //     'telefone' => '(12) 31231-2312',
        //     'cep' => '13140-693',
        //     'endereco' => 'Avenida José Pedro de Oliveira',
        //     'numero' => '871',
        //     'complemento' => 'LOJA C',
        //     'bairro' => 'Jardim América',
        //     'state_id' => '35',
        //     'city_id' => '3536505',
        // ]);

        // UserCompany::create([
        //     'company_id' => $company->id,
        //     'user_id' => $user_company->id
        // ]);

        // UserCompany::create([
        //     'company_id' => $company2->id,
        //     'user_id' => $user_company2->id
        // ]);

        // foreach (range(1, 10) as $index) {
        //     Funcao::create([
        //         'company_id' => $company->id,
        //         'title' => 'Funcao teste ' . $index,
        //         'status' => 1
        //     ]);
        // }

        // foreach (range(1, 10) as $index) {
        //     Funcao::create([
        //         'company_id' => $company2->id,
        //         'title' => 'Funcao teste ' . $index,
        //         'status' => 1
        //     ]);
        // }


        // foreach (range(1, 10) as $index) {
        //     Jornada::create([
        //         'company_id' => $company->id,
        //         'title' => 'Jornada Teste',
        //         'description' => 'Descricao da jornada'
        //     ]);
        // }

        // foreach (range(1, 10) as $index) {
        //     Jornada::create([
        //         'company_id' => $company2->id,
        //         'title' => 'Jornada Teste ' . $index,
        //         'description' => 'Descricao da jornada'
        //     ]);
        // }

        // foreach (range(1, 10) as $index) {
        //     $user_ = User::factory(1)->create([
        //         'role' => 3,
        //         'password' => bcrypt('123#456@_')
        //     ]);

        //     Funcionario::create([
        //         'user_id' => $user_[0]->id,
        //         'company_id' => $company->id,
        //         'jornada_id' => 3,
        //         'funcao_id' => 3,
        //         'celular' => '(12) 31231-2312',
        //         'telefone' => '(12) 31231-2312',
        //         'cpf' => '126.896.627-61',
        //         'estado_civil' => '1',
        //         'sexo' => '1',
        //         'grau_instrucao' => '1',
        //         'comorbidade' => '1,2,3',
        //         'cnh_numero' => '',
        //         'cnh_categoria' => '',
        //         'cep' => '13140-693',
        //         'endereco' => 'Rua Jose da Silva',
        //         'numero' => '871',
        //         'complemento' => 'AP 37 C',
        //         'bairro' => 'Jardim Europa',
        //         'state_id' => 35,
        //         'city_id' => 3536505,
        //         'cnh_numero' => '1123123123123',
        //         'cnh_categoria' => 'B',
        //         'rg' => '123123123',
        //         'rg_emissor' => 'detran',
        //         'rg_emissao' => '10/03/2020',
        //         'nascimento' => '10/02/1991',
        //         'nis' => '123123123',
        //         'carteira_reservista' => '123123123',
        //         'serie_reservista' => 'ASDASDASD',
        //         'zona_eleitoral' => '123123123',
        //         'secao_eleitoral' => 'AASDASDAS',
        //         'titulo_eleitoral' => '123123123',
        //         'nome_pai' => 'Julio',
        //         'nome_mae' => 'Neuza',
        //         'workHome => 'Sim'
        //     ]);
        // }

        // foreach (range(1, 10) as $index) {
        //     $user_ = User::factory(1)->create([
        //         'role' => 3,
        //         'password' => bcrypt('123#456@_')
        //     ]);

        //     Funcionario::create([
        //         'user_id' => $user_[0]->id,
        //         'company_id' => $company2->id,
        //         'jornada_id' => 3,
        //         'funcao_id' => 3,
        //         'celular' => '(12) 31231-2312',
        //         'telefone' => '(12) 31231-2312',
        //         'cpf' => '126.896.627-61',
        //         'estado_civil' => '1',
        //         'sexo' => '1',
        //         'grau_instrucao' => '1',
        //         'comorbidade' => '1,2,3',
        //         'cnh_numero' => '',
        //         'cnh_categoria' => '',
        //         'cep' => '13140-693',
        //         'endereco' => 'Rua Jose da Silva',
        //         'numero' => '871',
        //         'complemento' => 'AP 32 C',
        //         'bairro' => 'Vila Danese',
        //         'state_id' => 35,
        //         'city_id' => 3536505,
        //         'cnh_numero' => '1123123123123',
        //         'cnh_categoria' => 'B',
        //         'rg' => '123123123',
        //         'rg_emissor' => 'detran',
        //         'rg_emissao' => '10/03/2020',
        //         'nascimento' => '10/02/1991',
        //         'nis' => '123123123',
        //         'carteira_reservista' => '123123123',
        //         'serie_reservista' => 'ASDASDASD',
        //         'zona_eleitoral' => '123123123',
        //         'secao_eleitoral' => 'AASDASDAS',
        //         'titulo_eleitoral' => '123123123',
        //         'nome_pai' => 'Julio',
        //         'nome_mae' => 'Neuza'
        //         'workHome => 'Não'
        //     ]);
        // }





        // User::factory()->create([
        //     'name' => 'peixotopg',
        //     'email' => 'peixotopg@peixotopg.com',
        //     'role' => 2,
        //     'password' => bcrypt('123#456@_')
        // ]);
        // User::factory()->create([
        //     'name' => 'peixotoapc',
        //     'email' => 'peixotoapc@peixotoapc.com',
        //     'role' => 2,
        //     'password' => bcrypt('123#456@_')
        // ]);
        // User::factory()->create([
        //     'name' => 'newdent',
        //     'email' => 'newdent@newdent.com',
        //     'role' => 2,
        //     'password' => bcrypt('123#456@_')
        // ]);

        // $user_company = User::factory()->create([
        //     'name' => 'Karina',
        //     'email' => 'empresakarina@empresakarina.com',
        //     'role' => 2,
        //     'password' => bcrypt('123#456@_')
        // ]);

        // $user_company2 = User::factory()->create([
        //     'name' => 'Daiane',
        //     'email' => 'empresadaiane@empresadaiane.com',
        //     'role' => 2,
        //     'password' => bcrypt('123#456@')
        // ]);


        // $company = Company::create([
        //     'title' => 'Empresa karina',
        //     'logo' => 'https://pro7.nyc3.cdn.digitaloceanspaces.com/pictures/2/2_1692548195_mTzll6k9zYa6zUFCu8IK.jpg',
        //     'seguimento' => 'Entregas',
        //     'razao_social' => 'EMPRESA KARINA',
        //     'cnpj' => '12.312.312/3123-12',
        //     'telefone' => '(12) 31231-2312',
        //     'cep' => '22222-222',
        //     'endereco' => 'Avenida Oliveira',
        //     'numero' => '87',
        //     'complemento' => 'LOJA B',
        //     'bairro' => 'Jardim Teste',
        //     'state_id' => '35',
        //     'city_id' => '3536505',
        // ]);

        // $company2 = Company::create([
        //     'title' => 'EMPRESA DAIANE',
        //     'logo' => 'https://pro7.nyc3.cdn.digitaloceanspaces.com/pictures/2/2_1692548195_mTzll6k9zYa6zUFCu8IK.jpg',
        //     'seguimento' => 'Entregas',
        //     'razao_social' => 'EMPRESA DAIANE',
        //     'cnpj' => '12.312.312/3123-12',
        //     'telefone' => '(12) 31231-2312',
        //     'cep' => '22222-222',
        //     'endereco' => 'Avenida Oliveira',
        //     'numero' => '1',
        //     'complemento' => 'LOJA A',
        //     'bairro' => 'Jardim Teste',
        //     'state_id' => '35',
        //     'city_id' => '3536505',
        // ]);

        // UserCompany::create([
        //     'company_id' => $company->id,
        //     'user_id' => $user_company->id
        // ]);

        // UserCompany::create([
        //     'company_id' => $company2->id,
        //     'user_id' => $user_company2->id
        // ]);
    }
}
