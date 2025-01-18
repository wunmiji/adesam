const insightCanvas = document.getElementById('insightCanvas');
const insightPerMonthYearSelect = document.getElementById('insightPerMonthYear');


var styleChart = getComputedStyle(document.body);
var occasionColorChart = styleChart.getPropertyValue('--dashboard-occasion');
var productColorChart = styleChart.getPropertyValue('--dashboard-product');
var orderColorChart = styleChart.getPropertyValue('--dashboard-order');
var fontFamilyChart = styleChart.getPropertyValue('--chart-font-family');

// Set font family for all chart
Chart.defaults.font.family = fontFamilyChart;

var insightPerMonthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];


insightPerMonthYearSelect.addEventListener('change', function () {
    getAll(this.value);
});


var insightPerMonthChart = new Chart(insightCanvas, {
    type: 'line',
    data: {
        labels: insightPerMonthLabels,

    },
});

// Set default insight in current year
getAll(moment().year());

function removeData(chart) {
    chart.data = null;
    chart.data.labels = insightPerMonthLabels
    chart.update();
}

function getAll(year) {
    var occasionPerMonthAjaxUrl = baseUrlDataset + 'dashboard?occasion_per_month_year=' + year;
    var productPerMonthAjaxUrl = baseUrlDataset + 'dashboard?product_per_month_year=' + year;
    var orderPerMonthAjaxUrl = baseUrlDataset + 'dashboard?order_per_month_year=' + year;

    removeData(insightPerMonthChart);
    getAjax(occasionPerMonthAjaxUrl,
        function (output) {
            insightPerMonthChart.data.datasets.push(occasionPerMonthObject(JSON.parse(output)));
            insightPerMonthChart.update();
        }
    );
    getAjax(productPerMonthAjaxUrl,
        function (output) {
            insightPerMonthChart.data.datasets.push(productPerMonthObject(JSON.parse(output)));
            insightPerMonthChart.update();
        }
    );
    getAjax(orderPerMonthAjaxUrl,
        function (output) {
            insightPerMonthChart.data.datasets.push(orderPerMonthObject(JSON.parse(output)));
            insightPerMonthChart.update();
        }
    );
}


function occasionPerMonthObject(json) {
    return {
        label: 'Published Occasions',
        data: json,
        fill: false,
        borderColor: occasionColorChart,
        backgroundColor: occasionColorChart,
        tension: 0.1,
    };
}

function productPerMonthObject(json) {
    return {
        label: 'Publihsed Products',
        data: json,
        fill: false,
        borderColor: productColorChart,
        backgroundColor: productColorChart,
        tension: 0.1,
    };
}

function orderPerMonthObject(json) {
    return {
        label: 'Orders',
        data: json,
        fill: false,
        borderColor: orderColorChart,
        backgroundColor: orderColorChart,
        tension: 0.1,
    };
}

function bytesToSize(bytes) {
    var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    if (bytes == 0) return 'n/a';
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    if (i == 0) return bytes + ' ' + sizes[i];
    return (bytes / Math.pow(1024, i)).toFixed(1) + ' ' + sizes[i];
};




