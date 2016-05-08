<?php
	if(!isset($this->summoner) || !isset($this->summonerChamps) || !isset($this->score) || !isset($this->tries) || !(isset($this->level)) ){
		http_response_code(400);exit;
	}

	$i = 1;
	$points = 1000 * $this->level;
	$time = 60-(($this->level-1)*10);
	$time = ($time < 5) ? 5 : $time;
	$sliceControl = ($this->level>5) ? 5 : $this->level-1;
	$champions['points'] = array_slice($this->summonerChamps, 0, 6-$sliceControl);
	$champions['display'] = array_slice($this->summonerChamps, 6-$sliceControl, 10);
	foreach ($champions['points'] as $k => $champ) {
		$champions['points'][$k]['times'] = $i;
		$champions['points'][$k]['points'] = intval($points);
		$i=$i*2;
		$points = $points*0.35;
	}
	// Por cada valor que encuentre en $champion['points'] as $k => $champ agregarle cuantas veces va a aparecer
	// considerando $i como ese valor y que una vez que se guarde, multiplicar $i por 2
?>
<script type="text/javascript" src="<?php echo $this->conf->http_url; ?>src/js/js-cookie.js"></script>
<style type="text/css">
	#content {width: 94%;margin:0px 3%;}
	#game {width: 100%;max-width: 1600px;margin:0px auto;}
	#game img {width: 70px;height: 70px;background-color: white;margin: 5px;box-shadow: 0px 0px 5px 3px #000;cursor: pointer}
	#game img:focus, #game img:hover {opacity: 0.7}

	.wrong {box-shadow: 0px 0px 5px 5px #a00 !important;background-color: #500 !important}

	#levelAnnouncer {font-size: 50px;display: none}

	@media screen and (max-width: 1000px){
		#game {width: 1000px;}
	}
</style>

<h1 id="levelAnnouncer" class="bangers">LEVEL <?php echo $this->level; ?></h1>

<div id="game">
</div>

<script type="text/javascript">
	$("title").html("Level <?php echo $this->level; ?> &nbsp;::&nbsp; <?php echo $this->summoner['name']; ?> &nbsp;::&nbsp; Finder &nbsp;::&nbsp; Champion Master");
	$("#level span").text("<?php echo $this->level;?>");
	$("#time span").text("<?php echo $time; ?>");
	$("#score span").text("<?php echo $this->score;?>");
	$("#lives span").html("<?php for($i = 0; $i < $_COOKIE['tries'];$i++){ echo '<img src=\''.$this->conf->http_url.'src/img/heart-min.png\'>'; } ?>");
	$("#panel").fadeIn("fast");

	$champions = $.parseJSON('<?php echo str_replace("'","\'",json_encode($champions));?>');
	$countPoints = parseInt("<?php echo count($champions['points']); ?>");
	$countDisplay = parseInt("<?php echo count($champions['display']); ?>");
	$score = parseInt("<?php echo $this->score; ?>");
	$totalTime = parseInt("<?php echo $time; ?>");
	$next = false;

	$gameWidth = $("#game").width();

	if($gameWidth > 1000){
		$countWidth = parseInt($gameWidth/80);
	} else {
		$countWidth = parseInt($gameWidth/60);
	}

	$countHeight = parseInt(200/$countWidth);

	for (var i = 0; i < $countHeight; i++) {
		for(var ii = 0; ii < $countWidth; ii++){
			$k = Math.floor( Math.random() * $countDisplay );
			$champion = $champions.display[$k];
			$("#game").append('<img x="'+ii+'" y="'+i+'" k="'+$k+'" champId="'+$champion.data.id+'" src="'+ "<?php echo $this->conf->http_url.'src/img/'.$this->conf->version.'/champion/"+$champion.data.key+".png'; ?>" + '" >');
		}
	};

	$("#championsPoints").empty();
	for(var i = $countPoints - 1; i >= 0; i--){
		$champion = $champions.points[i];
		for(var ii = $champion.times; ii > 0; ii-- ){
			$("img[x='"+Math.floor( Math.random() * $countWidth )+"'][y='"+Math.floor( Math.random() * $countHeight )+"']").attr("k",i).attr("champId",$champion.data.id).attr("src", "<?php echo $this->conf->http_url.'src/img/'.$this->conf->version.'/champion/"+$champion.data.key+".png'; ?>");
		}
		$("#championsPoints").append('<h2><img src="'+"<?php echo $this->conf->http_url.'src/img/'.$this->conf->version.'/champion/"+$champion.data.key+".png'; ?>"+'"> x <span>'+$champion.points+'</span></h2>');
	}

	$("#content").imagesLoaded().then(function(){
		$("#levelAnnouncer").fadeIn(function(){
			setTimeout(function(){
				$("#levelAnnouncer").fadeOut(function(){
					$("#game").fadeIn();
					$timer = setInterval(function(){
						$totalTime = $totalTime-1;
						if($totalTime >= 0){
							$("#time span").text($totalTime);
						} else {
							clearInterval($timer);
							if($next){
								$.cookie('score',$score);
								$("#game").fadeOut(function(){
									consultar('next');
								});
							} else {
								$("#game").fadeOut(function(){
									endGame();
								});
							}
						}
					},1000);
				});
			}, 2000);
		});
	});

	$("#game img").click(function(){
		if($(this).attr("champId") == $champions.points[$(this).attr("k")].data.id){
			$next = true;
			$score = parseInt($score) + parseInt($champions.points[$(this).attr("k")].points);
			$("#score span").html($score);
			$(this).animate({opacity: 0},200).removeAttr("k").removeAttr("champId");
		} else {
			$.cookie('tries', parseInt($.cookie('tries') - 1) );
			$("#lives span").empty();
			$(this).addClass('wrong').animate({opacity:0.3},200).removeAttr("src");
			if($.cookie('tries') == 0){
				clearInterval($timer);
				endGame();
			} else {
				for(i = 0; i < $.cookie('tries'); i++){
					$("#lives span").append('<img src="'+"<?php echo $this->conf->http_url; ?>" + 'src/img/heart-min.png">');	
				}
			}
		}
	});

	function endGame(){
		$.cookie('score',$score);
		$("#game").fadeOut(function(){
			consultar("gameOver");
		});
	}
</script>