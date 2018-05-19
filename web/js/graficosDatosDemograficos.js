Highcharts.setOptions({
          chart: {
          renderTo:'graficos',
          plotBackgroundColor: null,
          plotBorderWidth: null,
          plotShadow: false,
          type: 'pie'
        },
        title: {
          text: 'Grafico de datos demograficos'
        },
        tooltip: {
          pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
          pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                  enabled: true,
                  format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                  style: {
                      color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                  }
              }
          }
        },
    });

	// ---- Gráfico de la evolución del peso mujeres hasta 13 semanas

function graficarDatosDemograficos(datos,nombredatos){
		setActive($(this));
		var options = {
      series: [{
        name: nombredatos,
        colorByPoint: true,
        data: datos
    }]
  }
		Highcharts.chart(options);
	};
