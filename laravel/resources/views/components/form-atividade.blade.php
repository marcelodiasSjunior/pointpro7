@csrf
<div class="">
    <div style="margin:25px 0px;">

        <div class="row">
            <div class="col-md-2 form-group mb-3"></div>
            <div class="col-md-8 form-group mb-3">
                <label for="funcao-atividade-add">Função</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="funcao-atividade-add">Função</span>
                    <select class="form-control inputFuncao" required name="funcao" onchange="loadUsersForFuncao()">
                        <option value="">SELECIONE</option>
                        @foreach($funcoes as $funcao)
                        <option value="{{ $funcao->id }}" {{ isset($atividade) && $atividade->funcao_id === $funcao->id ? 'selected' : '' }}>{{ $funcao->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2 form-group mb-3"></div>
        </div>

        <div class="row">
            <div class="col-md-2 form-group mb-3"></div>
            <div class="col-md-4 form-group mb-3">

                <div class="">
                    <label>Escolha um ou mais funcionários para desempenhar a atividade:</label>
                    <label class="checkbox checkbox-primary">
                        <input type="checkbox" name="funcionarios[]" value="todos"><span>TODOS</span><span class="checkmark"></span>
                    </label>
                    <div class='funcionarioHolder'>
                        @foreach($funcionarios as $funcionario)
                        <label class="checkbox checkbox-primary margin-check-3">
                            <input type="checkbox" value="{{ $funcionario->id }}" name="funcionarios[]" {{ isset($funcionarios_salvos) && in_array($funcionario->id, $funcionarios_salvos) ? 'checked' : ''}}><span>{{ $funcionario->user->name }}</span><span class="checkmark"></span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-4 form-group mb-3">

                <div class="">
                    <label>Escolha os dias da semana para a atividade:</label>

                    <label class="checkbox checkbox-primary">
                        <input type="checkbox" name="dias_da_semana[]" value="todos"><span class="badge rounded-pill text-bg-primary">TODOS</span><span class="checkmark"></span>
                    </label>
                    <label class="checkbox checkbox-primary margin-check-3">
                        <input type="checkbox" name="dias_da_semana[]" value="2" {{ isset($dias_salvos) && in_array(2, $dias_salvos) ? 'checked' : ''}}><span class="badge rounded-pill text-bg-primary">Segunda-feira</span><span class="checkmark"></span>
                    </label>
                    <label class="checkbox checkbox-primary margin-check-3">
                        <input type="checkbox" name="dias_da_semana[]" value="3" {{ isset($dias_salvos) && in_array(3, $dias_salvos) ? 'checked' : ''}}><span class="badge rounded-pill text-bg-primary">Terça-feira</span><span class="checkmark"></span>
                    </label>
                    <label class="checkbox checkbox-primary margin-check-3">
                        <input type="checkbox" name="dias_da_semana[]" value="4" {{ isset($dias_salvos) && in_array(4, $dias_salvos) ? 'checked' : ''}}><span class="badge rounded-pill text-bg-primary">Quarta-feira</span><span class="checkmark"></span>
                    </label>
                    <label class="checkbox checkbox-primary margin-check-3">
                        <input type="checkbox" name="dias_da_semana[]" value="5" {{ isset($dias_salvos) && in_array(5, $dias_salvos) ? 'checked' : ''}}><span class="badge rounded-pill text-bg-primary">Quinta-feira</span><span class="checkmark"></span>
                    </label>
                    <label class="checkbox checkbox-primary margin-check-3">
                        <input type="checkbox" name="dias_da_semana[]" value="6" {{ isset($dias_salvos) && in_array(6, $dias_salvos) ? 'checked' : ''}}><span class="badge rounded-pill text-bg-primary">Sexta-feira</span><span class="checkmark"></span>
                    </label>
                    <label class="checkbox checkbox-primary margin-check-3">
                        <input type="checkbox" name="dias_da_semana[]" value="7" {{ isset($dias_salvos) && in_array(7, $dias_salvos) ? 'checked' : ''}}><span class="badge rounded-pill text-bg-primary">Sábado</span><span class="checkmark"></span>
                    </label>
                    <label class="checkbox checkbox-primary margin-check-3">
                        <input type="checkbox" name="dias_da_semana[]" value="1" {{ isset($dias_salvos) && in_array(1, $dias_salvos) ? 'checked' : ''}}><span class="badge rounded-pill text-bg-primary">Domingo</span><span class="checkmark"></span>
                    </label>
                </div>
            </div>
            <div class="col-md-2 form-group mb-3"></div>
        </div>


        <div class="row">
            <div class="col-md-2 form-group mb-3"></div>
            <div class="col-md-8 form-group mb-3">
                <label for="basic-url">Descricao:</label>
                <div class="input-group mb-3">
                    <span class="input-group-text">Atividade</span>
                    <textarea class="form-control" name="description" required aria-label="With textarea" placeholder="" rows="4">{{ isset($atividade) ? $atividade->description : '' }}</textarea>
                </div>
            </div>
            <div class="col-md-2 form-group mb-3"></div>
        </div>

        <div class="row">
            <div class="col-md-12" style="text-align: center;">
                <button class="btn btn-primary" style="margin-top: 15px;min-width: 290px;"><b>GRAVAR</b></button>
            </div>
        </div>

    </div>

</div>