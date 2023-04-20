var chart = undefined;

async function options() {
    let value = document.getElementById("dataCity");
    let cities = await get_city();

    for (let city of cities) {

        let option = document.createElement("option");
        option.id = city.nome;
        option.innerHTML = city.nome;
        value.appendChild(option);
    }

    dataCity();
}

async function dataCity() {
    let value = document.getElementById("dataCity").value;

    // Download data
    let result = await get_by_city(value);
    let data = [];
    for (let item of result) {
        data.push({ x: item.data, y: item.valore })
    }

    // Grafico
    document.getElementById('getByCity').innerHTML = "";

    const ctx = document.getElementById('getByCity');

    // Destroy chart
    if (chart) chart.destroy();

    // Build chart
    chart = new Chart(ctx, {
        type: 'line',
        data: {
            datasets: [{
                data,
                tension: 0,
                label: "PM10"
            }],
        },
        options: {
            scales: {

                y: {
                    min: 0,
                },

            },
            elements: {
                point: {
                    radius: 0
                }
            }
        }
    });
}