let mutations = {
    // update variable value
    UPDATE_TOKEN(state, payload) {
        state.token = payload;
        state.configAuth.headers.Authorization =  `Bearer ${payload}`
    },
    SET_PROFILE(state, payload) {
        state.profile.user = payload.user;
        state.profile.account = payload.account;
    },
    SET_CATEGORIES(state,payload){
        state.categories = payload
    },
    SET_OPERATIONS(state,payload){
        state.operations = payload
    },
    SET_EXPENSES(state,payload){
        state.expenses = payload
    },
    SET_INCOME(state,payload){
        state.income = payload
    },
     SET_OPERATIONS_SEARCH(state,payload){
        state.operationsSearch = payload
    },
    SET_CHART_OPTIONS(state,payload){
        state.chart_circle_options_exp = [];
        state.chart_circle_options_inc = [];
        state.chart_line_options_exp = [];
        state.chart_line_options_inc = [];
        payload.circleExp.forEach((exp)=>{
            if(exp.operations_sum_amount){
                state.chart_circle_options_exp.push({value:exp.operations_sum_amount,name:exp.category_name})
            }
        })
        payload.circleInc.forEach((inc)=>{
            if(inc.operations_sum_amount){
            state.chart_circle_options_inc.push({value:inc.operations_sum_amount,name:inc.category_name})
            }
        })

        state.chart_line_options_exp = payload.expensesSumByMonth;
        state.chart_line_options_inc = payload.incomeSumByMonth;
    }
    ,
    SET_LOADER_SPINNER(state,payload){
        state.loader = payload
    },
    CLEAR_DATA(state){
        state.operations = [];
        state.profile.user = null;
        state.profile.account = null;
        state.categories = [];
        state.operationsSearch = [];
        state.expenses = 0
        state.income = 0
        state.chart_circle_options_exp = []
        state.chart_circle_options_inc = []
        state.chart_line_options_exp = []
        state.chart_line_options_inc = []
    }
}
export default mutations
