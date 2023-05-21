import state from "./state"

let getters = {
            // get state variable value
        getToken: (state) => state.token,
        getConfig: (state) =>state.configAuth,
        getProfile: (state)=> state.profile,
        getOperations:(state)=>state.operations,
        getOperationsSearch:(state)=>state.operationsSearch,
        getExpenses:(state)=>state.expenses,
        getIncome:(state)=>state.income,
        getCategories:(state)=>state.categories,
        getChartCircleOptionsExp:(state)=>state.chart_circle_options_exp,
        getChartCircleOptionsInc:(state)=>state.chart_circle_options_inc,
        getChartLineOptionsExp:(state)=>state.chart_line_options_exp,
        getChartLineOptionsInc:(state)=>state.chart_line_options_inc,
        getLoaderSpinner:(state)=>state.loader
}

export default getters
