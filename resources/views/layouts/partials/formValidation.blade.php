                        @if (count($errors))

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error) 
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                         </div>

                         @endif