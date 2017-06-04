{{ csrf_field() }}

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="col-md-4 control-label">Descrição*</label>

                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control" name="description" value="{{old('description', $request->description) }}" required autofocus>

                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('due_date') ? ' has-error' : '' }}">
                            <label for="due_date" class="col-md-4 control-label">Data limite(opcional)</label>

                            <div class="col-md-6">
                                <input id="date" type="text" class="form-control" name="due_date" value="{{ old('due_date', $due_date) }}">

                                @if ($errors->has('due_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('due_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
                            <label for="quantity" class="col-md-4 control-label">Número de cópias*</label>

                            <div class="col-md-6">
                                <input id="quantity" type="number" class="form-control" name="quantity" value="{{ old('quantity', $request->quantity) }}" required>

                                @if ($errors->has('quantity'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('quantity') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('colored') ? ' has-error' : '' }}">
                            <label for="colored" class="col-md-4 control-label">Impressão com cores*</label>

                            <div class="col-md-6" id="radio">
                                <input type="radio" name="colored" value="0" @if(old('colored', $request->colored) == 0) checked @endif> Não
                                <input type="radio" name="colored" value="1" @if(old('colored', $request->colored) == 1) checked @endif> Sim

                                @if ($errors->has('colored'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('colored') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('stapled') ? ' has-error' : '' }}">
                            <label for="stapled" class="col-md-4 control-label">Impressão com agrafo*</label>

                            <div class="col-md-6" id="radio">
                                <input type="radio" name="stapled" value="0" @if(old('stapled', $request->stapled) == 0) checked @endif> Não
                                <input type="radio" name="stapled" value="1" @if(old('stapled', $request->stapled) == 1) checked @endif> Sim

                                @if ($errors->has('stapled'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('stapled') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('front_back') ? ' has-error' : '' }}">
                            <label for="front_back" class="col-md-4 control-label">Frente e verso*</label>

                            <div class="col-md-6" id="radio">
                                <input type="radio" name="front_back" value="0" @if(old('front_back', $request->front_back) == 0) checked @endif> Não
                                <input type="radio" name="front_back" value="1" @if(old('front_back', $request->front_back) == 1) checked @endif> Sim

                                @if ($errors->has('front_back'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('front_back') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('paper_size') ? ' has-error' : '' }}">
                            <label for="paper_size" class="col-md-4 control-label">Tamanho do papel*</label>

                            <div class="col-md-6" id="radio">
                                <input type="radio" name="paper_size" value="3" @if(old('paper_size', $request->paper_size) == 3) checked @endif> A3
                                <input type="radio" name="paper_size" value="4" @if(old('paper_size', $request->paper_size) == 4) checked @endif> A4

                                @if ($errors->has('paper_size'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('paper_size') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('paper_type') ? ' has-error' : '' }}">
                            <label for="paper_type" class="col-md-4 control-label">Tipo de papel*</label>

                            <div class="col-md-6">
                                <select class="form-control" id="paper_type" name="paper_type" required="">
                                    <option disabled @if(is_null(old('paper_type', $request->paper_type))) selected @endif> -- Selecione um tipo de papel --</option>
                                    <option value="0" @if(!is_null(old('paper_type', $request->paper_type))) selected @endif>Rascunho</option>
                                    <option value="1" @if(old('paper_type', $request->paper_type) == 1) selected @endif>Normal</option>
                                    <option value="2" @if(old('paper_type', $request->paper_type) == 2) selected @endif>Fotografico</option>
                                   
                                </select>

                                @if ($errors->has('paper_type'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('paper_type') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
                            <label for="file" class="col-md-4 control-label">Ficheiro a imprimir</label>

                            <div class="col-md-6">
                                <input id="file" type="file" class="form-control" name="file" >

                                @if ($errors->has('file'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('file') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
