<?php
require_once "templates/page.php";

templatePage("Credits | ROBLOX Forums", function() { 
?>
<ul data-role = "listview" data-inset = "true">
<?php
    function format($array) {
		foreach($array as $name => $desc):
			echo "
			<li>
				<a href = 'http://www.roblox.com/User.aspx?UserName=$name' target = '_blank'>
					<img src = 'http://www.roblox.com/Thumbs/Avatar.ashx?x=100&y=100&Format=Png&username=$name'>
					<h3>$name</h3>
					<p>$desc</p>
				</a>
			</li>
			";
		endforeach;
	}
		
    $programmers = array(
		"Techboy6601" => "Techboy is the mastermind behind this project. It was his idea, and he loves working on it.", 
		"NXTBoy" => "As soon as NXTBoy joined, the project blossomed into something wonderful. He's the one who makes this project awesome.");
    $designers = array(
		"Garnished" => "Garnished is an amazing person to work with and he's given us some really good ideas.", 
		"testedmarkel62" => "The newest addition to our team, testedmarkel has offered some of his time to help us with graphics.");
?>
    <li data-role = "list-divider">
		<h3>Programmers</h3>
		<p>These are the people who make the site work like it does.</p>
	</li>
		<?php format($programmers); ?>
	<li data-role = "list-divider">
		<h3>Designers</h3>
		<p>And these are the people who make the site look like it does!</p>
	</li>
		<?php format($designers); ?>
</ul>
<?php }, NULL, function() {}); ?>