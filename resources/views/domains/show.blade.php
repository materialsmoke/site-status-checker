<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{$domain->name}}

                    <div>
                        Hours ago: <input type="text"> <input type="submit" value="submit">
                    </div>
                </div>
                
                <div>
                    <canvas id="myChart" width="400" height="400"></canvas>
                </div>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
const ctx = document.getElementById('myChart').getContext('2d');
let domainId = "{{$domain->id}}";

fetch('/curl-details/' + domainId).then(res=>res.json()).then(data=>{
    console.log('data', data);

    let labels = Array(data.length).fill('');
    let values = [];
    let colors = [];

    data.forEach(item => {
        if(item.status === "online"){
            values.push(1);
            colors.push('rgba(75, 192, 192, 0.2)');
        }else if(item.status === "offline"){
            values.push(-1);
            colors.push('rgba(255, 99, 132, 1)');
        }else if(item.status === "not_sent"){
            values.push(0.5);
            colors.push('rgba(255, 206, 86, 0.2)');
        }else{//if(item.status === "start")
            values.push(0.2);
            colors.push('rgba(153, 102, 255, 0.2)');
        }
    });


    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            // labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange', 'Orange', 'Orange', 'Orange'],
            
            labels: labels,
            datasets: [{
                label: '# of Votes',
                data: values,//[13, 19, 3, 5, 2, 3],
                backgroundColor: colors,
                // [
                //     'rgba(255, 99, 132, 0.2)',
                //     'rgba(54, 162, 235, 0.2)',
                //     'rgba(255, 206, 86, 0.2)',
                //     'rgba(75, 192, 192, 0.2)',
                //     'rgba(153, 102, 255, 0.2)',
                //     'rgba(255, 159, 64, 0.2)'
                // ],
                borderColor: colors,
                // [
                //     'rgba(255, 99, 132, 1)',
                //     'rgba(54, 162, 235, 1)',
                //     'rgba(255, 206, 86, 1)',
                //     'rgba(75, 192, 192, 1)',
                //     'rgba(153, 102, 255, 1)',
                //     'rgba(255, 159, 64, 1)'
                // ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

})


</script>

<script>

// const DATA_COUNT = 7;
// const NUMBER_CFG = {count: DATA_COUNT, min: -100, max: 100};

// const labels = Utils.months({count: 7});
// const data = {
//   labels: labels,
//   datasets: [
//     {
//       label: 'Fully Rounded',
//       data: Utils.numbers(NUMBER_CFG),
//       borderColor: Utils.CHART_COLORS.red,
//       backgroundColor: Utils.transparentize(Utils.CHART_COLORS.red, 0.5),
//       borderWidth: 2,
//       borderRadius: Number.MAX_VALUE,
//       borderSkipped: false,
//     },
//     {
//       label: 'Small Radius',
//       data: Utils.numbers(NUMBER_CFG),
//       borderColor: Utils.CHART_COLORS.blue,
//       backgroundColor: Utils.transparentize(Utils.CHART_COLORS.blue, 0.5),
//       borderWidth: 2,
//       borderRadius: 5,
//       borderSkipped: false,
//     }
//   ]
// };

// const ctx = document.getElementById('myChart').getContext('2d');
// const config = {
//   type: 'bar',
//   data: data,
//   options: {
//     responsive: true,
//     plugins: {
//       legend: {
//         position: 'top',
//       },
//       title: {
//         display: true,
//         text: 'Chart.js Bar Chart'
//       }
//     }
//   },
// };



</script>
                <br>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- @foreach ($curlDetails as $detail)
                        <div>
                            <span>
                            @if($detail->is_online) 
                                <span style="background-color: green"> 
                                    online 
                                </span> 
                            @else 
                                <span style="background-color: orange"> 
                                    offline 
                                </span> 
                            @endif 
                            </span> <span>{{$detail->created_at}}</span>
                        </div>
                    @endforeach --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
