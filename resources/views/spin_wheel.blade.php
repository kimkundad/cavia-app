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
        color:#000 
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
    top: 40%;
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
  img {
    position: absolute;
    width: 4em;
    top: 33%;
    right: -8%;
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
    img {
      right: -5%;
    }
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
                <div class="row justify-content-md-center">
                    <div class="col-md-8">
                        <div class="ps-form__header text-center">
                            <h2> หมุนวงล้อนำโชค</h2>
                        </div>
                        <div class="ps-section__content ">


                            <div class="row justify-content-md-center">
                                <div class="col-md-8">
                            <canvas id="wheel"></canvas>
                            <button id="spin-btn">Spin</button>
                            <img src="{{ url('img/spinner-arrow-.svg')}}" alt="spinner-arrow" />

                            <div id="final-value">
                                <p>Click On The Spin Button To Start</p>
                            </div>
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

const wheel = document.getElementById("wheel");
const spinBtn = document.getElementById("spin-btn");
const finalValue = document.getElementById("final-value");
//Object that stores values of minimum and maximum angle for a value
const rotationValues = [
  { minDegree: 0, maxDegree: 30, value: 2 },
  { minDegree: 31, maxDegree: 90, value: 1 },
  { minDegree: 91, maxDegree: 150, value: 6 },
  { minDegree: 151, maxDegree: 210, value: 5 },
  { minDegree: 211, maxDegree: 270, value: 4 },
  { minDegree: 271, maxDegree: 330, value: 3 },
  { minDegree: 331, maxDegree: 360, value: 2 },
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
    labels: [1, 2, 3, 4, 5, 6],
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
        color: "#ffffff",
        formatter: (_, context) => context.chart.data.labels[context.dataIndex],
        font: { size: 24 },
      },
    },
  },
});
//display value based on the randomAngle
const valueGenerator = (angleValue) => {
  for (let i of rotationValues) {
    //if the angleValue is between min and max then display it
    if (angleValue >= i.minDegree && angleValue <= i.maxDegree) {
      finalValue.innerHTML = `<p>Value: ${i.value}</p>`;
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
  spinBtn.disabled = true;
  //Empty final value
  finalValue.innerHTML = `<p>Good Luck!</p>`;
  //Generate random degrees to stop at
  let randomDegree = Math.floor(Math.random() * (355 - 0 + 1) + 0);

  console.log('ran', randomDegree)
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
    }
  }, 10);
});
</script>

@stop('scripts')