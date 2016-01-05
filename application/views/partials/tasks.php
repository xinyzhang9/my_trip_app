<header>
    
	<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
	<script>
      $(document).ready(function(){
        $('td.hidden_td').hide();
        $('input.btn-info').click(function(){
            var id = $(this).attr('id').split('_')[1];
            $('#task_'+id).hide();
            $('#hidden_'+id).show();

        });

        $('form.edit_task').submit(function(){
            $.post('/tasks/edit',$(this).serialize(),function(res){
                $('#tasks').html(res);
            });
            return false;
        })

        $('form.delete_task').submit(function(){
            $.post('/tasks/delete',$(this).serialize(),function(res){
                $('#tasks').html(res);
            });
            return false;
        })

        $('input.checkbox').click(function(){
            var id = $(this).attr('id').split('_')[1];
            // alert(id);
            var $this = $(this);

            if($this.is(':checked')){
                $(this).attr('disabled',true);
                $('#task_'+id).css("text-decoration","line-through");
                $('#task_'+id).css("color","gray");
                
            }
        })

      });//document ready
    </script>
</header>

    <div class="tasks">
        <h2>List of Tasks</h2>
    	<table class = 'table'>
    		<?php  
    			foreach ($tasks as $task) {
    		?>
    			<tr>
                    
                        <td><input type="button" id = "edit_<?=$task['id']?>" class = 'btn btn-info' value = 'Edit'></td>
                        <td>
                            <form class = "delete_task" action = "/tasks/delete" method = "post">
                                <input type="submit" class = 'btn btn-danger' value = 'Delete'>
                                <input type="hidden" name = 'id' value = '<?=$task['id']?>'>
                            </form>
                            
                        </td>
                        <td><input type="checkbox" class = 'checkbox' id = "check_<?=$task['id']?>"></td>
                        <td class = 'task_name' id = "task_<?=$task['id']?>">
                            <form class = "myform">
                                <?=$task['name']?>
                            </form>
                            
                        </td>
                        <td id = "hidden_<?=$task['id']?>" class = 'hidden_td'>
                            <form class = "edit_task" method = "post" id = "form_edit_<?=$task['id']?>">
                                <input type="text" name = 'name'>
                                <input type="hidden" name = 'id' value = '<?=$task['id']?>'>
                                <input type = 'submit' id ="btn_<?=$task['id']?>" class = 'btn btn-info' value = 'Submit' >

                            </form>
                        </td>
    			</tr>
    		<?php
    			}
    		?>		
    	</table>
    </div>