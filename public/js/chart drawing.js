$(document).ready(function() 
{
	var counter=0;
	jQuery.each(statistics, function(index, item) 
	{
		counter++;
		console.log(item['other_leave'],item);
		var ctx = $("#doughnut"+counter);
		//console.log(ctx);
		labels = [absense,attend_leave];
		data = [item['absence_counter'],item['attend_leave_counter']];
		if(item['other_attend'].length != 0) 
		{
			//console.log(item['other_attend']);
			jQuery.each(item['other_attend'], function(index_attend, item_attend) 
			{
				console.log(index_attend,item_attend);
				labels.push(index_attend);
				data.push(item_attend);
			});
		}
		if(item['other_leave'].length != 0) 
		{
			//console.log(item['other_leave']);
			jQuery.each(item['other_leave'], function(index_leave, item_leave) 
			{
				console.log(index_leave,item_leave);
				labels.push(index_leave);
				data.push(item_leave);
			});
		}
		
		var myChart = new Chart(ctx, 
		{
			type: 'doughnut',
			data: {
				labels: labels,
				datasets: [{
					label: '# of Attend & Leave',
					data: data,
					backgroundColor: [
						'rgba(220,20,60, 0.2)',
						'rgba(34,139,34, 0.2)',
						'rgba(70,130,180, 0.2)',
						'rgba(255,255,0, 0.2)',
						'rgba(153, 102, 255, 0.2)',
						'rgba(255, 159, 64, 0.2)'
					],
					borderColor: [
						'rgba(220,20,60, 1)',
						'rgba(34,139,34, 1)',
						'rgba(70,130,180, 1)',
						'rgba(255,255,0, 1)',
						'rgba(153, 102, 255, 1)',
						'rgba(255, 159, 64, 1)'
					],
					borderWidth: 1
				}]
			},
			options: {
				responsive: true,
				legend: {
							position: 'top',
						},
				title: {
					display: true,
					text: 'attend leave Chart'
				},
				animation: {
					animateScale: true,
					animateRotate: true
				},
				axes: {
					display: false,
				},
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true,
							display: false,
						},
						gridLines: {
							display:false,
						}
					}]
				}
			}
		});
		
		var ctx2 = $("#bar"+counter);
		//console.log(ctx2);
		var myChart2 = new Chart(ctx2, 
		{
			type: 'bar',
			data: {
				labels: labels,
				datasets: [{
					label: '# of Votes',
					data: data,
					backgroundColor: [
						'rgba(220,20,60, 0.2)',
						'rgba(34,139,34, 0.2)',
						'rgba(70,130,180, 0.2)',
						'rgba(255,255,0, 0.2)',
						'rgba(153, 102, 255, 0.2)',
						'rgba(255, 159, 64, 0.2)'
					],
					borderColor: [
						'rgba(220,20,60, 1)',
						'rgba(34,139,34, 1)',
						'rgba(70,130,180, 1)',
						'rgba(255,255,0, 1)',
						'rgba(153, 102, 255, 1)',
						'rgba(255, 159, 64, 1)'
					],
					borderWidth: 1
				}]
			},
			options: {
				responsive: true,
				legend: {
							position: 'top',
						},
				title: {
					display: true,
					text: 'attend leave Chart'
				},
				animation: {
					animateScale: true,
					animateRotate: true
				},
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true,

						}
					}]
				}
			}
		});	
		
	});
	
	
	
	
	/*var ctx = $(".doughnut");
	$(".doughnut").each(function(index, value) 
	{
		var myChart = new Chart($(this), 
		{
			type: 'doughnut',
			data: {
				labels: labels,
				datasets: [{
					label: '# of Attend & Leave',
					data: [12, 19, 3, 5, 2, 3],
					backgroundColor: [
						'rgba(255, 99, 132, 0.2)',
						'rgba(54, 162, 235, 0.2)',
						'rgba(255, 206, 86, 0.2)',
						'rgba(75, 192, 192, 0.2)',
						'rgba(153, 102, 255, 0.2)',
						'rgba(255, 159, 64, 0.2)'
					],
					borderColor: [
						'rgba(255, 99, 132, 1)',
						'rgba(54, 162, 235, 1)',
						'rgba(255, 206, 86, 1)',
						'rgba(75, 192, 192, 1)',
						'rgba(153, 102, 255, 1)',
						'rgba(255, 159, 64, 1)'
					],
					borderWidth: 1
				}]
			},
			options: {
				responsive: true,
				legend: {
							position: 'top',
						},
				title: {
					display: true,
					text: 'attend leave Chart'
				},
				animation: {
					animateScale: true,
					animateRotate: true
				},
				axes: {
					display: false,
				},
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true,
							display: false,
						},
						gridLines: {
							display:false,
						}
					}]
				}
			}
		});

	});

	var ctx2 = $(".bar");
	$(".bar").each(function(index, value) 
	{
		var myChart = new Chart($(this), 
		{
			type: 'bar',
			data: {
				labels: labels,
				datasets: [{
					label: '# of Votes',
					data: [12, 19, 3, 5, 2, 3],
					backgroundColor: [
						'rgba(255, 99, 132, 0.2)',
						'rgba(54, 162, 235, 0.2)',
						'rgba(255, 206, 86, 0.2)',
						'rgba(75, 192, 192, 0.2)',
						'rgba(153, 102, 255, 0.2)',
						'rgba(255, 159, 64, 0.2)'
					],
					borderColor: [
						'rgba(255, 99, 132, 1)',
						'rgba(54, 162, 235, 1)',
						'rgba(255, 206, 86, 1)',
						'rgba(75, 192, 192, 1)',
						'rgba(153, 102, 255, 1)',
						'rgba(255, 159, 64, 1)'
					],
					borderWidth: 1
				}]
			},
			options: {
				responsive: true,
				legend: {
							position: 'top',
						},
				title: {
					display: true,
					text: 'attend leave Chart'
				},
				animation: {
					animateScale: true,
					animateRotate: true
				},
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true,

						}
					}]
				}
			}
		});

	});*/
});