@extends('layouts.template')

@section('title')
เว็บแลกเปลี่ยนของรางวัล - Website
@stop

@section('stylesheet')

<style>
    .ps-block__header p {
       color:#000 
    }
    .img-fluid{
        width:100%;
        border-radius:10px;
    }
    .ps-section__content p {
        color:#fff;
        font-size: 18px
    }
   
    #wheel {
    max-height: inherit;
    width: inherit;
    top: 0;
    padding: 0;
    
  }
  @keyframes rotate {
    100% {
      transform: rotate(360deg);
    }
  }
  #spin-btn {
    position: absolute;
    transform: translate(-50%, -50%);
    top: 50%;
    left: 50%;
    height: 26%;
    width: 26%;
    border-radius: 50%;
    cursor: pointer;
    border: 0;
    background: radial-gradient(#fdcf3b 50%, #d88a40 85%);
    color: #c66e16;
    text-transform: uppercase;
    font-size: 1.8em;
    letter-spacing: 0.1em;
    font-weight: 600;
  }
  #spinner-arrow {
    position: absolute;
    width: 4em;
    top: 44%;
    right: -8%;
    z-index: 3;
  }
  #final-value {
    font-size: 1.5em;
    text-align: center;
    margin-top: 1.5em;
    color: #202020;
    font-weight: 500;
  }
  @media screen and (max-width: 768px) {
    .wrapper {
      font-size: 12px;
    }
    #spin-btn {
      right: -5%;
    }
  }
  #xxx{
    max-width: 370px;
    left: -24px;
    position: absolute;
    z-index: 1;
    width: 116%;
    top: -27px;
  }
  .text-label-bot{
    position: relative;
    top: -38px;
    z-index: 2;
  }
  .ps-table thead > tr > th {
    font-family: 'Kanit', sans-serif;
    font-size: 14px
}
.ps-table tbody > tr > td {
    vertical-align: middle;
    padding: 10px;
    border: 1px solid #ddd;
    color: #666;
}
.table-responsive {
    border: 3px solid #b163da;
}
.table thead th {
    border:none
}
.table td, .table th {
    border-top: 1px solid #8b35bc;
}
table {
    background-image: url("{{ url('img/background.jpg') }}");
}
#winner{
  width: 130px;
}
.box-winner{
  top: -60px;
    z-index: 2;
    margin: 0 auto;
    position: absolute;
    left: 80px;
}
.free-spin-day{
  font-size: 20px;
    color: #8b35bc;
}
.chakra-coin{
  width: 24px;
  height: 24px;
}
.chakra-coin2{
  width: 20px;
  height: 20px;
}
</style>

@stop('stylesheet')
@section('content')


<div class="ps-page--simple">
        <div class="ps-breadcrumb">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{ url('/') }}">หน้าหลัก</a></li>
                    <li>หมุนวงล้อนำโชค</li>
                </ul>
            </div>
        </div>

        <div class="ps-checkout ps-section--shopping" style="background-color: #fff; padding: 30px 0px 200px 0px">
            <div class="container">
                
                        <div class="ps-form__header text-center">
                            <br><br>
                        </div>
                        <div class="ps-section__content ">

                    
                    <div class="row justify-content-md-center">
                      
                        <div class="col-md-6" style="padding-right: 30px; padding-left: 30px;">
                          <div class="text-center">
                            @if($free_wheel == 0)
                          <h2 class="free-spin-day" id="free-spin-dayx">คุณได้สิทธิ์หมุนฟรี 1 ครั้ง/วัน</h2><br>
                          @else
                          <h2 class="free-spin-day" id="free-spin-dayx">
                            <img src="{{ url('/img/coin.png') }}" class="chakra-coin"> 
                            หมุนกงล้อมหาสนุก {{ number_format($coins_wheel_turn, 0) }} point</h2><br>
                          @endif
                          </div>
                          <div style="max-width:300px; margin: 0 auto; position: relative;" class="justify-content-md-center">
                            
                          <img id="xxx" src="{{ url('img/2159559-22222.png')}}" alt="spinner-bg" /> 
                            <div style="position: relative; z-index: 2;">
                            <canvas id="wheel"></canvas>
                            <button id="spin-btn">Spin</button>
                            <img id="spinner-arrow" src="{{ url('img/spinner-arrow-.svg')}}" alt="spinner-arrow" />
                            </div>
                            <div id="final-value">
                              <div style="position: relative; z-index: 2; ">
                              <img id="label_wheel" src="{{ url('img/label_wheel.png')}}" alt="label_wheel" /> 
                                <p id="final-text" class="text-white text-label-bot">คลิกที่ปุ่ม Spin เพื่อเริ่มเกมส์</p>
                              </div>
                            </div>
                            <br><br>
                          </div>
                        </div>
                        <div class="col-md-6" style="padding-right: 30px; padding-left: 30px;">
                          <div class="box-winner text-center">
                          <img id="winner" src="{{ url('img/winner-trophy.png')}}" alt="winner" /> 
                          </div>
                          <div style="max-width:400px; margin: 0 auto; position: relative;" class="justify-content-md-center">
                          <div class="table-responsive card" style="border-radius: 1.25rem;">
                            <table class="table table-dark" style="border-radius: 1rem; margin-bottom: 0rem;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>วัน/เวลา</th>
                                        <th>จำนวน</th>
                                    </tr>
                                </thead>
                                <tbody>

                                  @if(isset($user))
                                  @foreach($user as $u)
                                  <tr>
                                    <td>{{ $u->phone }}</td>  
                                    <td>{{ $u->date_time }}</td>  
                                    <td><img src="{{ url('/img/coin.png') }}" class="chakra-coin2">  {{ number_format($u->coins, 0) }} </td>  
                                  </tr>  
                                  @endforeach                                                                                                                                    
                                  @endif

                                </tbody>
                            </table>
                        </div>
                      </div>
                        </div>
                    </div>
                      
                        
                        </div>
                   
                
            </div>
        </div>
    </div>


@endsection

@section('scripts')

<!-- Chart JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<!-- Chart JS Plugin for displaying text over chart -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.1.0/chartjs-plugin-datalabels.min.js"></script>
<!-- Script -->

<script>


const getWheel = async() => {
    
    try {
      var result;
    await $.ajax({
            type: "GET",
            url: "{{url('api/data_wheel')}}",
            dataType: 'json',
            success: function (data) {
              result = data;
              
            }
        });
        return result;
      } catch (err) {
        console.log(err);
    }

}





const PostWheel = async() => {
  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
        }
    });
    try {
      var result;
    await $.ajax({
            type: "GET",
            url: "{{url('api/addwheelresult')}}",
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            dataType: 'json',
            success: function (data) {

              result = data;
              
            }
        });
        return result;
      } catch (err) {
        console.log(err);
    }

}


var my_coints;
var my_cointsxx;


const wheel = document.getElementById("wheel");
const spinBtn = document.getElementById("spin-btn");
const finalValue = document.getElementById("final-text");
//Object that stores values of minimum and maximum angle for a value
// const rotationValues = [
//   { minDegree: 0, maxDegree: 30, value: 2 },
//   { minDegree: 31, maxDegree: 90, value: 1 },
//   { minDegree: 91, maxDegree: 150, value: 6 },
//   { minDegree: 151, maxDegree: 210, value: 5 },
//   { minDegree: 211, maxDegree: 270, value: 4 },
//   { minDegree: 271, maxDegree: 330, value: 3 },
//   { minDegree: 331, maxDegree: 360, value: 2 },
// ]; const valueGenerator = (angleValue) => {

  var rotationValues = []
getWheel().then(function(res) {

    rotationValues = res
    console.log('----', rotationValues)
})

const dataLabel = [
  @if(isset($obj))
    @foreach($obj as $u)
    '{{$u->text}}',
    @endforeach
  @endif
];

//Size of each piece
const data = [16, 16, 16, 16, 16, 16];
//background color for each piece
var pieColors = [
  "#8b35bc",
  "#b163da",
  "#8b35bc",
  "#b163da",
  "#8b35bc",
  "#b163da",
];
//Create chart
let myChart = new Chart(wheel, {
  //Plugin for displaying text on pie chart
  plugins: [ChartDataLabels],
  //Chart Type Pie
  type: "pie",
  data: {
    //Labels(values which are to be displayed on chart)
    labels: dataLabel,
    //Settings for dataset/pie
    datasets: [
      {
        backgroundColor: pieColors,
        data: data,
      },
    ],
  },
  options: {
    //Responsive chart
    responsive: true,
    animation: { duration: 0 },
    plugins: {
      //hide tooltip and legend
      tooltip: false,
      legend: {
        display: false,
      },
      //display labels inside pie chart
      datalabels: {
        rotation: (context) =>
                context.dataIndex * (360 / context.chart.data.labels.length) +
                360 / context.chart.data.labels.length / 2 +
                270 +
                context.chart.options.rotation,
        color: "#ffffff",
        formatter: (_, context) => context.chart.data.labels[context.dataIndex],
        font: { 
          size: 16,
          family: 'Kanit',
         },
         align: 'start',
         anchor: 'end',
      },
    },
  },
});



//display value based on the randomAngle
const valueGenerator = (angleValue) => {
  for (let i of rotationValues) {
    //if the angleValue is between min and max then display it
    if (angleValue >= i.minDegree && angleValue <= i.maxDegree) {
      finalValue.innerHTML = `<p> ${i.message}</p>`;
      spinBtn.disabled = false;
      break;
    }
  }
};

//Spinner count
let count = 0;
//100 rotations for animation and last rotation for result
let resultValue = 101;
//Start spinning


spinBtn.addEventListener("click", () => {
  

  let randomDegree;
  //let randomDegree = Math.floor(Math.random() * (355 - 0 + 1) + 0);
  PostWheel().then(function(res2) {

    my_coints = document.getElementById("my_coints").innerText;
    my_cointsxx = document.getElementById("my_cointsxx").innerText;
    
    if(res2.status == 201){
    randomDegree = Math.floor(Math.random() * (res2.data.maxDegree - res2.data.minDegree) + res2.data.minDegree);
    console.log('status----', res2.status)


      spinBtn.disabled = true;
  //Empty final value
  finalValue.innerHTML = `<p>Good Luck!</p>`;
  //Generate random degrees to stop at

    console.log('ran', res2.minDegree, res2.maxDegree, randomDegree)
  //Interval for rotation animation
  let rotationInterval = window.setInterval(() => {
    //Set rotation for piechart
    /*
    Initially to make the piechart rotate faster we set resultValue to 101 so it rotates 101 degrees at a time and this reduces by 1 with every count. Eventually on last rotation we rotate by 1 degree at a time.
    */
    myChart.options.rotation = myChart.options.rotation + resultValue;
    //Update chart with new value;
    myChart.update();
    //If rotation>360 reset it back to 0
    if (myChart.options.rotation >= 360) {
      count += 1;
      resultValue -= 5;
      myChart.options.rotation = 0;
    } else if (count > 15 && myChart.options.rotation == randomDegree) {
      valueGenerator(randomDegree);
      clearInterval(rotationInterval);
      count = 0;
      resultValue = 101;

      document.getElementById("free-spin-dayx").innerHTML = '';
      document.getElementById("free-spin-dayx").innerHTML = 'หมุนกงล้อมหาสนุก {{ number_format($coins_wheel_turn, 0) }} point';

      document.getElementById("my_coints").innerHTML = '';
      document.getElementById("my_coints").innerHTML = parseInt(my_coints)+(res2.coin_return);
      document.getElementById("my_cointsxx").innerHTML = '';
      document.getElementById("my_cointsxx").innerHTML = parseInt(my_coints)+(res2.coin_return);
    }
  }, 10);

}else{
  swal("จำนวนเครดิตของคุณไม่เพียงพอ!", "", "error");
}

  console.log('----', randomDegree)
  })


  
});




</script>

@stop('scripts')