<template>
        <apexchart type="line" height="350" :options="chartOptions" :series="series"></apexchart>

</template>

<script setup>
const props = defineProps(["chartData", "chartTitle"]);

const sortedKeys = Object.keys(props.chartData).sort();
const sortedObj = {};

sortedKeys.forEach(key => {
  sortedObj[key] = props.chartData[key];
});

let series = [
    {
        name: props.chartTitle,
        data: Object.values(sortedObj),
    },
];
let chartOptions = {
    chart: {
        height: 350,
        type: "line",
        zoom: {
            enabled: false,
        },
    },
    dataLabels: {
        enabled: false,
    },
    stroke: {
        curve: "straight",
    },
    title: {
        text: props.chartTitle,
        align: "left",
    },
    grid: {
        row: {
            colors: ["#f3f3f3", "transparent"], // takes an array which will be repeated on columns
            opacity: 0.5,
        },
    },
    xaxis: {
        categories: Object.keys(sortedObj),
    },
};

console.log(props.chartData);
</script>

<style></style>
