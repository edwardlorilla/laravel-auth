<template>
        <line-chart v-if="getChartData"  :download="true" :data="transform.chart"/>
</template>
<script>
    export default{
        props:['user'],
        data() {
            return{
                reload: true,
                transform: {
                    chart: [{'name':'target', 'data':{}}, {'name':'ceta', 'data':{}}, {'name':'etd', 'data':{}}, {'name':'etp', 'data':{}}, {'name':'ets', 'data':{}}, {'name':'etse', 'data':{}}]
                },
            }
        },
        computed:{
            getChartData(){
                var vm = this
                return _.map(vm.user, function(data){
                    _.map(_.pick(data, ['target','ceta','etd','etp','ets','etse']),  function(value, key){
                        var index = _.findIndex(vm.transform.chart, ['name', key])
                        var date = `${data.school_year_start} - ${data.school_year_end}`
                        var pick = JSON.parse(`{"${data.semester === 1 ? '1st Sem. ' + date  : '2nd Sem. ' + date }":${value}}`);
                        return _.merge(vm.transform.chart[index].data, pick)
                    })
                })
            }
        },
    }
</script>
