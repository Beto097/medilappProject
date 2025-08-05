@if(isset($consultas))
    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
        <div class="panel panel-default card-view">
            <div class="panel-heading">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark">Consultas por Doctor Hoy</h6>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="flot-container" style="height:250px">
                        
                            <div id="flot_pie_chart2" class="demo-placeholder"></div>
                        
                        
                    </div>
                </div>
            </div>
        </div>	
    </div>
    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
        <div class="panel panel-default card-view">
            <div class="panel-heading">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark">Consultas por Doctor</h6>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="flot-container" style="height:250px">
                        <div id="flot_pie_chart" class="demo-placeholder"></div>
                    </div>
                </div>
            </div>
        </div>	
    </div>

@endif
@if(isset($consultas))
    @section('javaScript')
        <script>
            $(function () {
                "use strict";
        
                // Cargar colores desde el archivo JSON
                $.getJSON('{{ asset('js/tonos.json') }}', function (turquesas) {
        
                    // Solo si hay el contenedor del gráfico
                    if ($('#flot_pie_chart').length > 0) {
                        var pie_data = [
                            @foreach($consultas as $index => $examen)
                                
                                {
                                    label: '{{ $examen->doctor->primer_nombre_usuario }} {{ $examen->doctor->apellido_usuario }}: {{ $examen->total }}',
                                    data: {{ $examen->total }},
                                    color: "rgba(" + turquesas[Math.floor(Math.random() * 25) % turquesas.length].rgb.join(",") + ",1)"
                                },
                            @endforeach
                        ];
        
                        var pie_op = {
                            series: {
                                pie: {
                                    innerRadius: 0.5,
                                    show: true,
                                    stroke: {
                                        width: 0,
                                    }
                                }
                            },
                            legend: {
                                backgroundColor: 'transparent',
                            },
                            grid: {
                                hoverable: true
                            },
                            color: null,
                            tooltip: true,
                            tooltipOpts: {
                                content: "%p.0%, %s",
                                shifts: {
                                    x: 20,
                                    y: 0
                                },
                                defaultTheme: false
                            },
                        };
        
                        $.plot($("#flot_pie_chart"), pie_data, pie_op);
                    }
        
                });
            });
        </script>
    
        <script>

            $(function() {
                "use strict";
                
                $.getJSON('{{ asset('js/tonos.json') }}', function (turquesas) {
                /***Pie Chart***/
                    if( $('#flot_pie_chart2').length > 0 ){
                        var pie_data = [
                            @foreach($consultasD as $index => $examen)
                                
                                {
                                    label: '{{ $examen->doctor->primer_nombre_usuario }} {{ $examen->doctor->apellido_usuario }}: {{ $examen->total }}',
                                    data: {{ $examen->total }},
                                    color: "rgba(" + turquesas[Math.floor(Math.random() * 25) % turquesas.length].rgb.join(",") + ",1)"
                                },
                            @endforeach
                         ];

                        var pie_op = {
                            series: {
                                pie: {
                                    innerRadius: 0.5,
                                    show: true,
                                    stroke: {
                                        width: 0,
                                    }
                                }
                            },
                            legend : {
                                backgroundColor: 'transparent',
                            },
                            grid: {
                                hoverable: true
                            },
                            color: null,
                            tooltip: true,
                            tooltipOpts: {
                                content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                                shifts: {
                                    x: 20,
                                    y: 0
                                },
                                defaultTheme: false
                            },
                        };
                        $.plot($("#flot_pie_chart2"), pie_data, pie_op);
                    }
        
                    });
                });

        </script> 
    @endsection
@endif