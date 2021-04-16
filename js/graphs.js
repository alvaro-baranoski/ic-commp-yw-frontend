const modebar_config = {
	modeBarButtonsToRemove: ['lasso2d',
		'select2d',
		'sendDataToCloud',
		'toggleHover',
		'hoverClosestCartesian',
		'toggleSpikelines']
}

let time_window = 60;
let sample_frequency = 5;
let order = 10;

console.log("testing...");

toggleViews('loading');

$(document).ready(function () {

	// Page first load
	startup();
	toggleViews('working');

	// Refresh page every five minutes
	window.setInterval(function () {
		toggleViews('loading');

		setTimeout(function () {
			startup();
			toggleViews('working');
		},
			2000);

	},
		300000);
})


// This function works at page change
function startup() {
	$.ajax({
		url: 'graphs.php',
		data: { action: 'startup', pmu: $("#select-pmu").text(), time_w: time_window, sample_freq: sample_frequency, order: order },
		method: 'GET',
		dataType: 'json',
		async: false,
		success: function (response) {
			draw_graph1(response.date, response.freq);
			draw_graph2(response.welch_freq, response.welch);

			//Updates time and informs user
			$("#last-update-time").html(new Date().toLocaleDateString() + " " +
				new Date().toLocaleTimeString('en-GB', {
					hour: "numeric",
					minute: "numeric",
					second: "numeric"
				}));
		}
	});
}

// Function that activates at button click
$('#button_id').on('click', function () {

	// Checks time window value
	if ($("#time_window_select").val() !== "")
		time_window = parseInt($("#time_window_select").val());

	// Checks sample frequency value
	if ($("#sample_frequency_select").val() !== "")
		sample_frequency = parseInt($("#sample_frequency_select").val());

	// Checks model order value
	if ($("#order_select").val() !== "")
		order = parseInt($("#order_select").val());

	if (5 <= time_window && time_window <= 60 &&
		1 <= sample_frequency && sample_frequency <= 20 &&
		2 <= order && order <= 30) {

		toggleViews('loading');

		setTimeout(function () {
			startup();
			toggleViews('working');
		},
			2000);
	}
});

// Utility function for switching between page views
function toggleViews(status) {
	switch (status) {
		case 'working':
			$("#graph1").show();
			$("#graph2").show();
			$("#loading").hide();
			$("#last-update").show();
			break;

		case 'unavailable':
			$("#graph1").hide();
			$("#graph2").hide();
			$("#loading").hide();
			$("#last-update").hide();
			break;

		case 'loading':
			$("#graph1").hide();
			$("#graph2").hide();
			$("#loading").show();
			$("#last-update").hide();
			break;
	}
}

function draw_graph1(data_x, data_y) {
	var layout;
	var trace = [];

	layout = {
		title: 'Frequência de operação do SEP',
		xaxis: {
			title: 'Tempo'
		},
		yaxis: {
			title: 'Frequência [Hz]'
		}
	}

	trace.push({
		x: data_x,
		y: data_y,
		mode: 'lines',
		type: 'scatter'
	})

	Plotly.newPlot('graph1', trace, layout, modebar_config);
}

function draw_graph2(data_x, data_y) {
	var layout;
	var trace = [];

	layout = {
		title: 'Modos eletromecânicos',
		xaxis: {
			title: 'Frequência [Hz]'
		},
		yaxis: {
			title: 'Amortecimento [%]'
		}
	}

	trace.push({
		x: data_x,
		y: data_y,
		mode: 'markers',
		type: 'scatter'
	})

	Plotly.newPlot('graph2', trace, layout, modebar_config);
}