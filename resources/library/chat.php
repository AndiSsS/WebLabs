	<div id="app" class="container">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-10">
								<span class="glyphicon glyphicon-comment"></span>
								<span class="chat-header"><?php echo $_SESSION["username"] ?></span>
							</div>
							<div class="col-xs-2">
								<a href="logout.php">
									<button class="btn btn-danger log-out">
										<span class="glyphicon glyphicon-log-out"></span>
									</button>
								</a>
							</div>
						</div>
					</div>
					<div class="panel-body">
						<ul id="ul-chat" class="chat">
							<?php 
							$stmt = $pdo->query("SELECT * FROM `chat_messages` ORDER BY `when` DESC LIMIT 100");

							while ($row = $stmt->fetch())
							{
								$username = $row["username"];
								$message = $row["message"];
								$when = date('m/d/Y G:i:s', $row["when"]);
								$imgUrl = getUserImageUrl($row["username"]);

								if(!isset($_SESSION["lastMessageId"]) || $_SESSION["lastMessageId"] < $row["id"])
									$_SESSION["lastMessageId"] = $row["id"];

// 								echo <<<EOL
// 							    <li class="left clearfix">
// 									<span class="chat-img pull-left">
// 										<img src="{$imgUrl}" class="img-circle" />
// 									</span>
// 									<div class="chat-body clearfix">
// 										<div class="header">
// 											<strong class="primary-font Nombre" >{$username}</strong> 
// 											<small class="pull-right text-muted">{$when}</small>
// 										</div>
// 										<p class="message">
// 											{$message}
// 										</p>
// 									</div>
// 								</li>
// EOL;								

								echo '<message  text="'.$message.'" 
												username="'.$username.'"
												date-time="'.$when.'" 
												image-url="'.$imgUrl.'"></message> 
									';
							}
							
							?>
						</ul>
					</div>
					<div class="panel-footer">
						<div class="input-group">
							<input id="input-message" type="text" class="form-control input-sm" placeholder="Write a message..." />
							<span class="input-group-btn">
								<button class="btn btn-warning btn-sm" id="btn-submit" type="submit">
								Say</button>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<li style="display:none" id="message-template" class="left clearfix">
		<span class="chat-img pull-left">
			<img id="message-image" src="http://placehold.it/50/55C1E7/fff&text=" class="img-circle" />
		</span>
		<div class="chat-body clearfix">
			<div class="header">
				<strong id="message-username" class="primary-font Nombre"></strong> 
				<small id="message-time" class="pull-right text-muted" id="message-time"></small>
			</div>
			<p id="message-text" class="message"></p>
		</div>
	</li>

<script>
	Vue.component('message', {
		props: ['text', 'username', 'dateTime', 'imageUrl'],
		template: `
		<div>
			<li id="message-template" class="left clearfix">
				<span class="chat-img pull-left">
					<img id="message-image" :src="imageUrl" class="img-circle" />
				</span>
				<div class="chat-body clearfix">
					<div class="header">
						<strong id="message-username" class="primary-font Nombre">{{ username }}</strong> 
						<small id="message-time" class="pull-right text-muted" id="message-time">{{ dateTime }}</small>
					</div>
					<p id="message-text" class="message">{{ text }}</p>
				</div>
			</li>
		<div>

		`
	})
	new Vue({
		el: '#app',
	});
</script>