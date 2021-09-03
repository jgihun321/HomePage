@extends('layout.mainlayout')

@if(!empty($video))

@section('title',$video->title)

@section('body')


<div class='embed-responsive embed-responsive-16by9'>
    <div style='text-align:center'>
            <video class = 'embed-responsive-item' src='{{$video->link}}' id='myvideo' controls autoplay loop width='100%'  controlsList='nodownload'></video>
    </div>
</div>

@endsection


<script>

@section('addscript')

var myvideo = document.getElementById('myvideo');

myvideo.volume = 0.3;

 if ('mediaSession' in navigator) {

  navigator.mediaSession.metadata = new MediaMetadata({
    title: '{{$video->title}}',
    artist: '{{$video->singer}}',
    /*artwork: [
      { src: 'https://dummyimage.com/96x96',   sizes: '96x96',   type: 'image/png' }
    ]*/
  });
}

@endsection
</script>

@else

@section('title','은지네')

@section('body')
    <div class='embed-responsive embed-responsive-16by9'>
        <div style='text-align:center'>
    <video class = "embed-responsive-item" src="" id="myvideo" controls autoplay  controlsList="nodownload" ></video>
        </div>
    </div>
@endsection
<script>
@section('addscript')


var video = [@foreach($list as $video)"{{$video->link}}",@endforeach];


const link = [@foreach($list as $video)"{{$video->link}}",@endforeach];
const title = [@foreach($list as $video)"{{$video->title}}",@endforeach];
const singer = [@foreach($list as $video)"{{$video->singer}}",@endforeach];





var returnArray = video.slice();
var len = returnArray.length;
var i = len;
while(i--) {
    var arrayRandomNo = parseInt(Math.random() * len);
    var tmpValue = returnArray[i];

    returnArray[i] = returnArray[arrayRandomNo];
    returnArray[arrayRandomNo] = tmpValue;

}

myvideo.volume = 0.3;



var myvid = document.getElementById('myvideo');

if ('mediaSession' in navigator) {

    navigator.mediaSession.metadata = new MediaMetadata({
        title: title[link.indexOf(returnArray[0])],
        artist: singer[link.indexOf(returnArray[0])],
        /*artwork: [
          { src: 'https://dummyimage.com/96x96',   sizes: '96x96',   type: 'image/png' }
        ]*/
    });
}
document.title = title[link.indexOf(returnArray[0])];
myvid.src = returnArray[0];
myvid.play();

var activeVideo = 0;
var count = 0;
myvid.addEventListener('ended', function(e) {
    // update the new active video index
    activeVideo = (++activeVideo) % returnArray.length;
    count++;
    // update the video source and play
    if (count == len){
        myvid.removeEventListener('ended');
        /*count = 0;
        var i = len;
        while(i--) {
            var arrayRandomNo = parseInt(Math.random() * len);
            var tmpValue = returnArray[i];

            returnArray[i] = returnArray[arrayRandomNo];
            returnArray[arrayRandomNo] = tmpValue;
        }*/
    }






    myvid.src = returnArray[activeVideo];

    if ('mediaSession' in navigator) {
    document.title = title[link.indexOf(returnArray[activeVideo])];
        navigator.mediaSession.metadata = new MediaMetadata({
            title: title[link.indexOf(returnArray[activeVideo])],
            artist: singer[link.indexOf(returnArray[activeVideo])],
            /*artwork: [
              { src: 'https://dummyimage.com/96x96',   sizes: '96x96',   type: 'image/png' }
            ]*/
        });
    }


    myvid.play();
});

    @endsection
</script>
@endif
