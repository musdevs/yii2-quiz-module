<?php
/**
 *  Maybe this is a bad idea, but I don't know how to pass template string
 *  to JS without make it in global scope. 
 */
?>
<?php $script = <<< JS
    
    function g_add_many() {
        event.preventDefault();
        var in_group = '$template';
        $('.g_answer_container[data-question="$questionTypeId"] table').prepend(in_group);
    }
    
    function g_chkManyClick(elem) {
        var input = $(elem).parents('tr').find('input[type="text"]');
        var other = $('input[data-control="chk_many"]').not(elem);
        
        input.attr('name', 'right_many[]');
        input.parent('div').toggleClass('has-success');
    }
JS;

echo $script;
