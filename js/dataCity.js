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

const blue = ["#36a2eb", "#9ad0f5"];
const orange = ["#fea047", "#fec784"];
var chart;
async function dataCity() {
  let value = document.getElementById("dataCity").value;

  // Set color
  const color = value === "VR-Giarol Grande PM2,5" ? orange : blue;

  // Download and build data
  let result = await get_by_city(value);
  let data = [];
  for (let item of result) {
    data.push({ x: item.data, y: item.valore });
  }

  // Get chart
  const ctx = document.getElementById("getByCity");

  // Destroy chart
  if (chart) chart.destroy();

  // Build chart
  chart = new Chart(ctx, {
    type: "line",
    data: {
      datasets: [
        {
          data,
          tension: 0,
          label: "PM10",
          borderColor: color[0],
          backgroundColor: color[1],
        },
      ],
    },
    options: {
      scales: {
        x: {
          type: "time",
          time: {
            unit: "month",
          },
        },
        y: {
          min: 0,
        },
      },
      elements: {
        point: {
          radius: 0,
        },
      },
    },
  });
}
