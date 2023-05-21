let state = {
    //define variables
    token: localStorage.getItem("token") || 0,
    configAuth: {
        headers: {
            Accept: "application/json",
            Authorization: null,
        },
    },
    profile: {
        user: null,
        account: null,
    },
    categories: [],
    operations: [],
    operationsSearch: [],
    expenses: 0,
    income: 0,
    chart_circle_options_exp: [],
    chart_circle_options_inc: [],
    chart_line_options_exp:[],
    chart_line_options_inc:[],
    loader:true
};

export default state;
