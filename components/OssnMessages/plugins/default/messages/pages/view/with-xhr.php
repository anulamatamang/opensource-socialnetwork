<div class="message-with">
<div class="message-inner" id="message-append-<?php echo $params['user']->guid; ?>" data-guid='<?php echo $params['user']->guid; ?>'>
<?php
echo ossn_view_pagination($params['count'], 10, array(
	'offset_name' => 'offset_message_xhr_with',															 
));
if ($params['data']) {
				$user = ossn_user_by_guid($params['data'][0]->message_from);
                foreach ($params['data'] as $message) {
					$deleted = false;
					$class = '';
					if(isset($message->is_deleted) && $message->is_deleted == true){
								$deleted = true;
								$class = ' ossn-message-deleted';
					}						
					if($user->guid == ossn_loggedin_user()->guid){
					?>
                    	<div class="row">
                                <div class="col-md-10">
                                	<div class="message-box-sent text<?php echo $class;?>">
                                    		<?php if($deleted){ ?>
                                            <span><i class="fa fa-times-circle"></i><?php echo ossn_print('ossnmessages:deleted');?></span>
                        					<?php } else { ?>	
						<span><?php echo ossn_call_hook('messages', 'message:smilify', null, ossn_message_print($message->message)); ?></span>
                        					<?php } ?>
                                        	<div class="time-created">
												<?php echo ossn_user_friendly_time($message->time);?>
												<?php if(!$deleted){ ?>
                                            		<a class="ossn-message-delete" href="<?php echo ossn_site_url("action/message/delete?id={$message->id}", true);?>"><i class="fa fa-times"></i></a>				
                                            	<?php } ?>                                            
                                            </div>    
                                        </div>
                                </div>
                        	<div class="col-md-2">
                                	<img  class="user-icon" src="<?php echo $user->iconURL()->small;?>" />
                                </div>                                
                        </div>
                    <?php	
					} else {
						?>
                    	<div class="row">
                        	<div class="col-md-2">
                                	<img  class="user-icon" src="<?php echo $user->iconURL()->small;?>" />
                                </div>                                
                                <div class="col-md-10">
                                	<div class="message-box-recieved text<?php echo $class;?>">
                                            <?php if($deleted){ ?>
                                            <span><i class="fa fa-times-circle"></i><?php echo ossn_print('ossnmessages:deleted');?></span>
                        					<?php } else { ?>
					    <span><?php echo ossn_call_hook('messages', 'message:smilify', null, ossn_message_print($message->message)); ?></span>
                                            <?php } ?>						
                                        	<div class="time-created"><?php echo ossn_user_friendly_time($message->time);?></div>                                                
                                        </div>
                                </div>
                        </div>                       
                        <?php
					}
				}
}
?>
</div>
</div>
