@if($historico_action)
<div style="margin:25px 0px;">
    <form method="get" action="{{ $historico_action }}">
        <div class="row">
            <div class="col-md-2 form-group mb-3">
            <label for="picker1">Selecionar o dia</label>
                <select class="form-control" name="dia">
                    @foreach(range(1, $daysInMonth) as $index)
                    <option {{ $dayNumber == $index ? "selected" : ''}}>{{ $index < 10 ? "0".$index : $index }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 form-group mb-3">
                <label for="picker1">Selecionar mês</label>
                <select class="form-control" name="mes">
                    @foreach($monthList as $key => $value)
                    <option value="{{ $key }}" {{ $monthNumber == $key ? "selected" : ''}}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 form-group mb-3">
                <label for="picker1">Selecionar ano</label>

                <select class="form-control" name="ano">
                    @foreach(range($yearMin, $yearMax) as $index)
                    <option {{ $yearNumber == $index  ? "selected" : ''}}>{{ $index }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary" style="margin-top: 24px;">Pesquisar</button>
            </div>
        </div>
    </form>
</div>
@endif