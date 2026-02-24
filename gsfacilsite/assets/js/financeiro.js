$(function () {
	'use strict'

	var ticksStyle = {
		fontColor: '#495057',
		fontStyle: 'bold'
	}

	var mode = 'index'
	var intersect = true



	/*
	  // EXEMPLOS
	  document.querySelector('.devProd').forEach((item)=>{
		  item.addEventListener('click', (e)=>{
			e.preventDefault();
		  	
		  });
	  });

	  // CHARTS VENDAS MESES
	let enviarChart = document.querySelector('#atualizarChart');
	enviarChart.addEventListener('click', (e) => {
		e.preventDefault();
		console.log('here');
	});

	informação:
	https://www.chartjs.org/docs/latest/developers/updates.html
	*/

	



	// Sales
	var $salesChart = $('#sales-chart')
	var salesChart = new Chart($salesChart, {
		type: 'bar',
		data: {
			labels: labels,
			datasets: [
				{
					backgroundColor: color1,
					borderColor: color1,
					data: values
				},
				{
					backgroundColor: color2,
					borderColor: color2,
					data: valuesOld
				}
			]
		},
		options: {
			maintainAspectRatio: false,
			tooltips: {
				mode: mode,
				intersect: intersect
			},
			hover: {
				mode: mode,
				intersect: intersect
			},
			legend: {
				display: false
			},
			scales: {
				yAxes: [{
					// display: false,
					gridLines: {
						display: true,
						lineWidth: '4px',
						color: 'rgba(0, 0, 0, .2)',
						zeroLineColor: 'transparent'
					},
					ticks: $.extend({
						beginAtZero: true,

						// Include a dollar sign in the ticks
						callback: function (value, index, values) {
							if (value >= 1000) {
								value /= 1000
								value += 'k'
							}
							return '$' + value
						}
					}, ticksStyle)
				}],
				xAxes: [{
					display: true,
					gridLines: {
						display: false
					},
					ticks: ticksStyle
				}]
			}
		}
	})



	/*Function to update the bar chart*/
	function updateBarGraph(chart, label, color, data) {
		chart.data.datasets.pop();
		chart.data.datasets.push({
			label: label,
			backgroundColor: color,
			data: data
		});
		chart.update();
	}



})





function addData() {
	var chart = $('#sales-chart');

	// meses
	let labels = ['JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
	// ano anterior
	let valuesOld = [65000, 64000, 69800, 65200, 72100, 85000, 88800];
	// ano posterior
	let values = [75000, 64900, 72200, 64300, 69900, 89000, 105200];

	let data = 
		[
			{
				backgroundColor: '#007bff',
				borderColor: '#007bff',
				data: values
			},
			{
				backgroundColor: '#ced4da',
				borderColor: '#ced4da',
				data: valuesOld
			}
		]
	

	console.log('here');
	chart.data.labels.push(labels);
	chart.data.datasets.forEach((dataset) => {
		dataset.data.push(data);
	});
	chart.update();
}
