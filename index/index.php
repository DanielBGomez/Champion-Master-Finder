<style type="text/css">
	#content {width: 90%;margin: 0px 5%;display: flex;min-height: 100vh}
	.separador {margin: 50px auto;}
	.separador p {text-align: justify;font-size: 18px;margin-bottom: 10px;}
	.separador h1 {margin-bottom: 10px;text-transform: capitalize;font-size: 40px}

	.button {padding: 15px 30px;border-radius: 15px; border: #555 1px solid;box-shadow: 0px 0px 5px 2px #333;font-variant: small-caps;font-weight: 700; margin: 5px 10px;display: inline-block;}
	.button:hover, .button:focus {opacity: 0.7; box-shadow: 0px 0px 5px 5px #333}
	.random {background-color: rgba(120,80,80,0.8)}
	.select {background-color: rgba(120,120,150,0.8)}
	.best {background-color: rgba(120,150,120,0.8)}
</style>

<div id="content">
	<div style="width: 100%;margin: auto;padding: 96px 0px 105px; max-width:1200px">
		<div class="separador">
			<h1>Finder - Be fast and find your best champions!</h1>
			<p>
				In the <b>Champion Master Finder</b>, you must find your best champions <small>( Based on your Champions' Mastery Score )</small> wich are scattered in a grid that contains your top 10 champions!
				Only the best of the best will give you points, also the more mastery points it has, the more points you'll earn but it will be less times in the grid.
				For each level, the champions will worth more points, the last one will be removed and you'll have less time!
				<br><br>In this game mode all the levels and games are unique, even when the summoner name is the same, since all data is printed completely random! This achieves that there is a different gaming experience for each user.
				<br><br><small>NOTE: You can't play if you don't have at least 10 champions with mastery points!</small>
			</p>
			<a href="<?php echo $core->conf->http_url; ?>finder" class="button random">Find your Champions</a>
			<a href="<?php echo $core->conf->http_url; ?>finder?scores" class="button best">Top 10 Scores</a>
		</div>
	</div>	
</div>