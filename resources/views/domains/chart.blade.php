
<div class="p-6 bg-white border-b border-gray-200" lang="en-us">

    {{$domain->name}}

    <div>
        {{-- Minutes ago: <input type="text" id="minutes" value="1440"> <input id="submit" type="submit" value="submit"> --}}
        Start date: <input type="text" name="startDate" id="startDate" >
        <br>
        End date: <input type="text" id="endDate" name="endDate"> 
        <br>
        <input id="submit" type="button" value="submit" style="border:1px solid rgb(68, 255, 0); padding:10px; margin:10px;background-color:rgba(119, 255, 126, 0.192)">
    </div>
    <div>
        <div>How many days ago:</div>
        <br>
        <span id="span1" style="padding: 10px; margin: 3px; background-color:rgb(164, 164, 255);text-align:center">1</span>
        <span id="span2" style="padding: 10px; margin: 3px; background-color:rgb(164, 164, 255);text-align:center">2</span>
        <span id="span3" style="padding: 10px; margin: 3px; background-color:rgb(164, 164, 255);text-align:center">3</span>
        <span id="span4" style="padding: 10px; margin: 3px; background-color:rgb(164, 164, 255);text-align:center">4</span>
        <span id="span5" style="padding: 10px; margin: 3px; background-color:rgb(164, 164, 255);text-align:center">5</span>
        <span id="span6" style="padding: 10px; margin: 3px; background-color:rgb(164, 164, 255);text-align:center">6</span>
        <span id="span7" style="padding: 10px; margin: 3px; background-color:rgb(164, 164, 255);text-align:center">7</span>
        <span id="span8" style="padding: 10px; margin: 3px; background-color:rgb(164, 164, 255);text-align:center">8</span>
        <span id="span9" style="padding: 10px; margin: 3px; background-color:rgb(164, 164, 255);text-align:center">9</span>
        <span id="span10" style="padding: 10px; margin: 3px; background-color:rgb(164, 164, 255);text-align:center">10</span>
    </div>
</div>


<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
    
</script>

{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.2.0/dist/css/datepicker.min.css">
<script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.2.0/dist/js/datepicker-full.min.js"></script>
<script>
    const elemS = document.querySelector('input[name="startDate"]');
    const datepickerS = new Datepicker(elemS, {
        "defaultViewDate":new Date()
    }); 
    const elemE = document.querySelector('input[name="endDate"]');
    const datepickerE = new Datepicker(elemE, {
        "defaultViewDate":new Date()
    }); 

    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate');

</script> --}}


<script>
    let domainId = "{{$domain->id}}";
</script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
    $( function() {
        var myDate = new Date();
        var dateStart = ('0'+ (myDate.getMonth()+1)).slice(-2)  + '/' + ('0'+ (myDate.getDate() - 1)).slice(-2) + '/' + myDate.getFullYear();
        var dateEnd = ('0'+ (myDate.getMonth()+1)).slice(-2)  + '/' + ('0'+ myDate.getDate()).slice(-2) + '/' + myDate.getFullYear();
        var startDateV = $( "#startDate" ).datepicker().val(dateStart).val();
        var endDateV = $( "#endDate" ).datepicker().val(dateEnd).val();

        const selectDayHandler = (daysAgo) =>{
            console.log(daysAgo)
            dateStart = ('0'+ (myDate.getMonth()+1)).slice(-2)  + '/' + ('0'+ (myDate.getDate() - daysAgo )).slice(-2) + '/' + myDate.getFullYear();
            dateEnd = ('0'+ (myDate.getMonth()+1)).slice(-2)  + '/' + ('0'+ (myDate.getDate() - daysAgo + 1)).slice(-2) + '/' + myDate.getFullYear();
            startDateV = $( "#startDate" ).datepicker().val(dateStart).val();
            endDateV = $( "#endDate" ).datepicker().val(dateEnd).val();

            drawChart();
            drawBasic();

        }
        document.getElementById('span1').addEventListener('click', ()=>selectDayHandler(1));
        document.getElementById('span2').addEventListener('click', ()=>selectDayHandler(2));
        document.getElementById('span3').addEventListener('click', ()=>selectDayHandler(3));
        document.getElementById('span4').addEventListener('click', ()=>selectDayHandler(4));
        document.getElementById('span5').addEventListener('click', ()=>selectDayHandler(5));
        document.getElementById('span6').addEventListener('click', ()=>selectDayHandler(6));
        document.getElementById('span7').addEventListener('click', ()=>selectDayHandler(7));
        document.getElementById('span8').addEventListener('click', ()=>selectDayHandler(8));
        document.getElementById('span9').addEventListener('click', ()=>selectDayHandler(9));
        document.getElementById('span10').addEventListener('click', ()=>selectDayHandler(10));



        console.log(startDateV, 's');
        console.log(endDateV, 's');
        d = JSON.stringify({
                        "startDate": startDateV,
                        "endDate": endDateV,
                        // minutes:minutes.value
                    })
                    console.log(d);
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            let donutChartHandler = () => {
                // let startDate = document.getElementById('startDate');
                // let endDate = document.getElementById('endDate');
                // console.log('minutes', minutes.value);
                fetch('/curl-details/' + domainId, {
                    method: "post",
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },

                    //make sure to serialize your JSON body
                    body: JSON.stringify({
                        "startDate": startDateV,
                        "endDate": endDateV,
                        // minutes:minutes.value
                    })
                    
                }).then(res=>res.json()).then(data=>{
                    console.log('data', data);

                    let labels = Array(data.length).fill('');
                    let online = 0;
                    let offline = 0;
                    let start = 0;
                    let not_sent = 0;


                    data.forEach(item => {
                        if(item.status === "online"){
                            online++;
                        }else if(item.status === "offline"){
                            offline++;
                        }else if(item.status === "not_sent"){
                            not_sent++;
                        }else{//if(item.status === "start")
                            start++;
                        }
                    });
                    let donutChartData = google.visualization.arrayToDataTable([
                        ['Status', 'Online or offline'],
                        ['Online', online],
                        ['Offline', offline + +not_sent],
                        // ['Offline', not_sent],
                        ['Testing', start],
                    ]);
                    let options = {
                        title: 'Status',
                        pieHole: 0.4,
                        slices: {
                            0: { color: '#3366CC' },
                            1: { color: '#800000' },
                            // 2: { color: '#DC3912' },
                            2: { color: '#000000' }
                        }
                    };
                    let donutChart = new google.visualization.PieChart(document.getElementById('donutchart'));
                    donutChart.draw(donutChartData, options);
                });
                let submitBtn = document.getElementById('submit');
                submitBtn.addEventListener('click', donutChartHandler);
            };
            donutChartHandler();
        }




        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawBasic);
        function drawBasic() {
            let barChartHandler = ()=>{
                // let startDate = document.getElementById('startDate');
                // let endDate = document.getElementById('endDate');
                let sumResponseTime = 0;
                let countPositiveResponseTime = 0;
                // console.log('minutes2', minutes.value);
                fetch('/curl-details/' + domainId, {
                    method: "post",
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    //make sure to serialize your JSON body
                    body: JSON.stringify({
                        "startDate": startDateV,
                        "endDate": endDateV,
                    })
                }).then(res=>res.json()).then(data=>{
                    console.log('data2', data);
                    let labels = Array(data.length).fill('');
                    let online = 0;
                    let offline = 0;
                    let start = 0;
                    let not_sent = 0;
                    let chartDataArray = [
                        ['Element', 'Status', { role: 'style' }]
                    ];
                    data.reverse().forEach(item => {
                        if(item.response_time_milliseconds > 0){
                            countPositiveResponseTime++;
                            sumResponseTime += item.response_time_milliseconds;
                        }
                        let state;
                        let color = "";
                        if(item.status === "online"){
                            online++;
                            state = +(item.response_time_milliseconds/1000).toFixed(2);
                            color = "#3366CC"
                        }else if(item.status === "offline"){
                            offline++;
                            state = -2;
                            color = "#800000"
                        }else if(item.status === "not_sent"){
                            not_sent++;
                            state = -1.5;
                            color = "#DC3912"
                        }else{//if(item.status === "start")
                            start++;
                            state = 0.5;
                            color = "black"
                        }
                        let updatedAt = new Date(item.updated_at);
                        let datestring = updatedAt.getDate()  + "-" + (updatedAt.getMonth()+1) + "-" + updatedAt.getFullYear() + " " + updatedAt.getHours() + ":" + updatedAt.getMinutes();

                        chartDataArray.push([
                            datestring,
                            state,
                            color,
                        ])
                    });
                    let barChartData = google.visualization.arrayToDataTable(chartDataArray
                    //    [
                    //     // ['Element', 'Status', { role: 'style' }],
                    //     // ['Copper', 8.94, '#b87333'],            // RGB value
                    //     // ['Silver', 10.49, 'silver'],            // English color name
                    //     // ['Gold', 19.30, 'gold'],
                    //     // ['Platinum', 21.45, 'color: #e5e4e2' ], // CSS-style declaration
                    //    ]
                    );
                    let options = {
                        title: `Average response time: ${((sumResponseTime / countPositiveResponseTime) / 1000).toFixed(2)} seconds`,
                        hAxis: {
                            title: 'Time',
                            format: 'h:mm a',
                            // viewWindow: {
                            //     min: [700, 30000, 0],
                            //     max: [1700, 3000, 0]
                            // }
                        },
                        vAxis: {
                            title: 'Status: -1 (offline) to 1 (online)'
                        },
                        
                    };
                    let barChart = new google.visualization.BarChart(document.getElementById('BarChart_chart_div'));
                    barChart.draw(barChartData, options);
                });
                let submitBtn = document.getElementById('submit');
                submitBtn.addEventListener('click', barChartHandler);
            };
            barChartHandler();
        }

        
    } );
    // const startDates = $('#startDate').val();
    // const endDate = document.getElementById('endDate');
    
</script> 
 

<div id="donutchart" style="width: 900px; height: 500px;"></div>


<script type="text/javascript">

</script>

<div >

    <div id="BarChart_chart_div"  style="width: 500px; height: 2500px;" ></div>
</div>
