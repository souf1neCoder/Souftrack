<template>
<div class="py-8 w-full">
            <apexchart type="polarArea" :options="chartOptions" :series="series"></apexchart>
</div>
</template>

<script setup>
const props = defineProps(["chartData"]);


let series = props.chartData.map((s)=>{
    return parseFloat(s.value);
})
let labels = props.chartData.map((s)=>{
    return s.name;
})

let chartOptions = {
    chart: {
              type: 'polarArea',
            },
            labels:labels,
            stroke: {
              colors: ['#fff']
            },
            fill: {
              opacity: 0.8
            },
            responsive: [{
              breakpoint: 400,
              options: {
                chart: {
                  width: '100%'
                },
                legend: {
                  position: 'bottom'
                }
              }
            }]
}

console.log(series)
console.log(props.chartData)

</script>

<style></style>
