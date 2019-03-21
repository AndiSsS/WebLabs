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
							$messages = array();

							while ($row = $stmt->fetch())
							{
								$messages[] = [ 'username' => $row["username"],
												'text' => $row["message"],
												'when' => date('m/d/Y G:i:s', $row["when"]),
												'imgUrl' => getUserImageUrl($row["username"])];

								if(!isset($_SESSION["lastMessageId"]) || $_SESSION["lastMessageId"] < $row["id"])
									$_SESSION["lastMessageId"] = $row["id"];						

							}

							echo '<message :messages=messages></message>';
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
<script>
	// Створюєм компонент message
	Vue.component('message', {
		// Визначаєм вхідні данні
		props: {
			// Тип - масив, обов'язковий параметр
			messages: {
				type: Array,
				required: true
			}
		},
		// Визначаємо шаблон для повідомлення
		template: `
		<div>
			<li v-for="message in messages" :key="message.when" class="left clearfix">
				<span class="chat-img pull-left">
					<img :src="message.imgUrl" class="img-circle" />
				</span>
				<div class="chat-body clearfix">
					<div class="header">
						<strong class="primary-font Nombre">{{ message.username }}</strong> 
						<small class="pull-right text-muted" >{{ message.when }}</small>
					</div>
					<p class="message">{{ message.text }}</p>
				</div>
			</li>
		</div>
		`
	})
	// Створюєм головний об'єкт Vue
	var vue = new Vue({
		// Прив'язуєм об'єкт до елементу з індексом "app"
		el: '#app',
		// Визначаєм данні об'єкту
		data: {
			// Створюєм масив повідомлень
			messages: [	
			<?php
				// Перебираєм кожне повідомлення і вставляєм його
	            foreach ($messages as $message) {
	                echo ' { text: "' . $message["text"] . '", 
	                		 username: "' . $message["username"] . '",
	                		 when: "' . $message["when"] . '" ,
	                		 imgUrl: "' . $message["imgUrl"] . '" },';
	            }
	        ?>
	        ]
		}
	});
</script>