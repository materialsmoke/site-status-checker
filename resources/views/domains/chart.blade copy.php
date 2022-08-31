
<div class="p-6 bg-white border-b border-gray-200">

{{$domain->name}}

<div>
    Minutes ago: <input type="text" id="minutes" value="1440"> <input id="submit" type="submit" value="submit">
</div>

</div>



<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
google.charts.load("current", {packages:["corechart"]});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {

    
    
    let donutChartHandler = () => {
        
        let minutes = document.getElementById('minutes');
        console.log('minutes', minutes.value);
        fetch('/curl-details/' + domainId, {
            method: "post",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },

            //make sure to serialize your JSON body
            body: JSON.stringify({
                minutes:minutes.value
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
                ['Error', offline],
                ['Offline', not_sent],
                ['Testing', start],
            ]);

            let options = {
                title: 'Status',
                pieHole: 0.4,
                slices: {
                    0: { color: '#3366CC' },
                    1: { color: '#800000' },
                    2: { color: '#DC3912' },
                    3: { color: '#000000' }
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
</script>

<script>
let domainId = "{{$domain->id}}";
</script>

<div id="donutchart" style="width: 900px; height: 500px;"></div>








<script type="text/javascript">
google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawBasic);

function drawBasic() {


let barChartHandler = ()=>{

    let minutes = document.getElementById('minutes');
    console.log('minutes2', minutes.value);
    fetch('/curl-details/' + domainId, {
        method: "post",
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },

        //make sure to serialize your JSON body
        body: JSON.stringify({
            minutes:minutes.value
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
        

        data.forEach(item => {
            let state;
            let color = "";
            if(item.status === "online"){
                online++;
                state = 1;
                color = "#3366CC"
            }else if(item.status === "offline"){
                offline++;
                state = -1;
                color = "#800000"
            }else if(item.status === "not_sent"){
                not_sent++;
                state = -0.5;
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
            title: 'Status',
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

        let barChart = new google.visualization.ColumnChart(document.getElementById('chart_div'));

        barChart.draw(barChartData, options);

    });
    let submitBtn = document.getElementById('submit');
    submitBtn.addEventListener('click', barChartHandler);
    
};


barChartHandler();
  

    
}
</script>

<div style="display: fixed">

<div id="chart_div" ></div>
</div>
