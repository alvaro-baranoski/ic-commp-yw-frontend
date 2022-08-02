
window.addEventListener('load', () => {

	// Page first load
	cluster();

	// Refresh page every five minutes
	window.setInterval(() => cluster(), 300000);
});

// This function works at page change
function cluster() {
    toggleViews('loading');

	const params = { action: 'cluster' };

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
            
            updateView(res["main_modes"]);

            toggleViews('working');

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

function updateView(res) {
    const tbody = document.querySelector("tbody");
    let count = 1;
    res.forEach((mode) =>{ 
        let row = 
        `
        <tr>
            <th scope="row">${count}</th>
            <td>${mode["freq_interval"][0]} ~ ${mode["freq_interval"][1]}</td>
            <td>${mode["damp_interval"][0]} ~ ${mode["damp_interval"][1]}</td>
            <td>${mode["presence"]}</td>
        </tr>
        `;
        tbody.innerHTML = tbody.innerHTML + row;
        count += 1;
    });
}

function cb(response) {
    const div = document.getElementById('number-access-div');
    const span = document.getElementById('number-access');
    div.classList.remove('d-none');
    span.innerHTML = response.value;
}

// Utility function for switching between page views
function toggleViews(status) {
	switch (status) {
		case 'working':
			show('main_modes_div');
            show('last-update');
            hide('loading');
			hide('pmu-error');
			break;

		case 'unavailable':
			hide('main_modes_div');
            hide('last-update');
            hide('loading');
			show('pmu-error');
			break;

		case 'loading':
			hide('main_modes_div');
            hide('last-update');
            show('loading');
			hide('pmu-error');
			break;
	}
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