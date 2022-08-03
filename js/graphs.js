const modebar_config = {
	modeBarButtonsToRemove: ['lasso2d',
		'select2d',
		'sendDataToCloud',
		'toggleHover',
		'hoverClosestCartesian',
		'toggleSpikelines']
}

// Default values
let time_window = 20;
let sample_frequency = 100;
let order = 20;
let filterLower = 0.3;
let filterHigher = 7.0;
let outlierConstant = 5;
let view = 'simplificada';

let res;

toggleViews('loading');

window.addEventListener('load', () => {
	// Page first load
	startup();

	// Refresh page every five minutes
	window.setInterval(() => startup(), 300000);
})


// This function works at page change
function startup() {

	toggleViews('loading');

	const params = {
		action: 'startup', 
		pmu: $("#select-pmu").text(),
		time_w: time_window,
		sample_freq: sample_frequency,
		order: order,
		filter_lower: filterLower,
		filter_higher: filterHigher,
		outlier_constant: outlierConstant,
		view: view
	};

	$.ajax({
		url: 'graphs.php',
		data: params,
		method: 'GET',
		dataType: 'json',
		async: true,
		success: function (response) {
			// Check de falha na requisição
			if (response === null) {
				toggleViews('unavailable');
				return;
			}
			
			res = JSON.parse(response);

			dashboard();

			res.view === "simplificada" ? toggleViews('working') : toggleViews('working-complete');
			
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

// Dashboard view selection button click
$('#dashboard-select-div').on('click', () => {
	const checkbox = document.getElementById('dashboard-select-checkbox');
	const form = document.getElementById('page-form');
	// Complete dashboard
	if (checkbox.checked) {
		form.classList.remove('d-none');
		setPlaceholder();
		view = 'complete';
		toggleViews('working-complete');
	} 
	// Simplified dashboard
	else {
		form.classList.add('d-none');
		view = 'simplificada';
		toggleViews('working');
	}
})

// Update button click
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

	// filter lower frequency
	if ($("#filter_lower_select").val() !== "") 
		filterLower = parseFloat($("#filter_lower_select").val());

	// filter higher frequency
	if ($("#filter_higher_select").val() !== "")
		filterHigher = parseFloat($("#filter_higher_select").val());

	// filter lower frequency
	if ($("#outliner_select").val() !== "")
		outlierConstant = parseFloat($("#outliner_select").val());

	startup();
	
});

function dashboard() {
	const main_modes = res.main_modes;
	$('#freq_range').text(`${main_modes[0].freq_interval[0]} Hz ~ ${main_modes[0].freq_interval[1]} Hz`);
	$('#damp_range').text(`${main_modes[0].damp_interval[0]}% ~ ${main_modes[0].damp_interval[1]}%`);
	$('#mode_presence').text(`${main_modes[0].presence}`);
	
	$('#freq_range_2').text(`${main_modes[1].freq_interval[0]} Hz ~ ${main_modes[1].freq_interval[1]} Hz`);
	$('#damp_range_2').text(`${main_modes[1].damp_interval[0]}% ~ ${main_modes[1].damp_interval[1]}%`);
	$('#mode_presence_2').text(`${main_modes[1].presence}`);

	// View completa
	draw_graph1(res.date, res.freq);
	draw_graph2(res.modes, res.damp);
	
	// Plot de sinal pré-processado
	draw_graph_processed(res.date, res.freq_process);
	// Plot de diagrama de estabilização convencional
	draw_stabilization_diagram(
		res.c_mpf, 
		res.c_f, 
		res.c_stab_freq_fn, 
		res.c_stab_freq_mn, 
		res.c_stab_fn,
		res.c_stab_mn,
		res.c_not_stab_fn,
		res.c_not_stab_mn
	);
	// Plot de diagrama de estabilização 3d
	draw_3d_diagram(res.d3_freq, res.d3_damp);
}

// Utility function for switching between page views
function toggleViews(status) {
	switch (status) {
		case 'working':
			show('main_modes_div');
			hide('graph1');
			hide('graph2');
			hide('graph_processed');
			hide('graph_conv_stab');
			hide('graph_3d_stab');
			hide('loading');
			show('last-update');
			show('pmu-location');
			hide('pmu-error');
			break;

		case 'working-complete':
			hide('main_modes_div');
			show('graph1');
			show('graph2');
			show('graph_processed');
			show('graph_conv_stab');
			show('graph_3d_stab');
			hide('loading');
			show('last-update');
			show('pmu-location');
			hide('pmu-error');
			break;

		case 'unavailable':
			hide('main_modes_div');
			hide('graph1');
			hide('graph2');
			hide('graph_processed');
			hide('graph_conv_stab');
			hide('graph_3d_stab');
			hide('loading');
			hide('last-update');
			show('pmu-location');
			show('pmu-error');
			break;

		case 'loading':
			hide('main_modes_div');
			hide('graph1');
			hide('graph2');
			hide('graph_processed');
			hide('graph_conv_stab');
			hide('graph_3d_stab');
			show('loading');
			hide('last-update');
			hide('pmu-location');
			hide('pmu-error');
			break;
	}
}

function draw_graph1(data_x, data_y) {
	var layout;
	var trace = [];

	layout = {
		title: 'Power grid operating frequency',
		xaxis: {
			title: 'Time'
		},
		yaxis: {
			title: 'Frequency [Hz]'
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
		title: 'Electromechanical modes',
		xaxis: {
			title: 'Frequency [Hz]'
		},
		yaxis: {
			title: 'Damping ratio [%]'
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

function draw_graph_processed(data_x, data_y) {
	var layout;
	var trace = [];

	layout = {
		title: 'Preprocessed frequency',
		xaxis: {
			title: 'Time'
		},
		yaxis: {
			title: 'Frequency [Hz]'
		}
	}

	trace.push({
		x: data_x,
		y: data_y,
		mode: 'lines',
		type: 'scatter'
	})

	Plotly.newPlot('graph_processed', trace, layout, modebar_config);
}

function draw_stabilization_diagram(c_mpf, c_f, c_stab_freq_fn, c_stab_freq_mn, c_stab_fn, c_stab_mn, c_not_stab_fn, c_not_stab_mn) {
	
	// Modos estáveis em frequência 
	const trace1 = {
		x: c_stab_freq_fn,
		y: c_stab_freq_mn,
		type: 'scatter',
		mode: 'markers',
		name: "Frequency stable modes",
	};

	// Modos estáveis em frequência e amortecimento
	const trace2 = {
		x: c_stab_fn,
		y: c_stab_mn,
		type: 'scatter',
		mode: 'markers',
		name: "Frequency and damping stable modes",
	};

	// Modos não estáveis
	const trace3 = {
		x: c_not_stab_fn,
		y: c_not_stab_mn,
		type: 'scatter',
		mode: 'markers',
		name: 'Not stable modes',
	};

	// Função de resposta em frequência
	const trace4 = {
		x: c_f,
		y: c_mpf,
		type: 'scatter',
		name: 'Frequency response function',
		yaxis: 'y2'
	};

	const data = [trace1, trace2, trace3, trace4];

	const layout = {
		title: "Conventional stabilization diagram",
		xaxis: {
			title: 'Frequency [Hz]',
			range: [c_f[0], c_f[c_f.length - 1]]
		},
		yaxis: {
			title: "Modes",
			range: [0, order + 0.5]
		},
		yaxis2: {
			title: "Magnitude",
			overlaying: "y",
			side: "right",
			type: "log",
			autorange: true
		},
		showlegend: true,
		legend: {
			orientation: 'h',
			xanchor: 'center',
			y: 1.1,
			x: 0.5
		},
	}

	Plotly.newPlot('graph_conv_stab', data, layout, modebar_config);
}

function draw_3d_diagram(d3_freq, d3_damp) {
	const data = [{
		x: d3_freq,
		y: d3_damp,
		autobinx: false,
		xbins: {
			start: 0,
			end: 2.5,
			size: 0.1
		},
		autobiny: false,
		ybins: {
			start: 0,
			end: 50,
			size: 1
		},
		type: 'histogram2d',
		colorscale: 'Hot',
	}];

	const layout = {
		title: 'Stabilization histogram',
		xaxis: {
			title: 'Frequency [Hz]'
		},
		yaxis: {
			title: 'Damping ratio [%]'
		}
	}

	Plotly.newPlot('graph_3d_stab', data, layout);
}

// DOM Manipulation functions
function show(elementId) {
	const element = document.getElementById(elementId);
	if (!element) return;
	if (element.classList.contains('d-none')) {
		element.classList.remove('d-none');
	}
}

function hide(elementId) {
	const element = document.getElementById(elementId);
	if (!element) return;
	if (!element.classList.contains('d-none')) {
		element.classList.add('d-none');
	}
}

function setPlaceholder() {
	// Checks time window value
	$("#time_window_select").attr("placeholder", time_window);

	// Checks sample frequency value
	$("#sample_frequency_select").attr("placeholder", sample_frequency);

	// Checks welch segment window
	$("#order_select").attr("placeholder", order);

	// filter lower frequency
	$("#filter_lower_select").attr("placeholder", filterLower);

	// filter higher frequency
	$("#filter_higher_select").attr("placeholder", filterHigher);

	// filter lower frequency
	$("#outliner_select").attr("placeholder", outlierConstant);
}