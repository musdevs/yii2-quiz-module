<?php
/**
 *  Maybe this is a bad idea, but I don't know how to pass template string
 *  to JS without make it in global scope.
 */
?>
<?php $script = <<< JS
    
    function g_add_one(event) {
        event.preventDefault();
        var in_group = '$template';
        $('.g_answer_container[data-question="$questionTypeId"] table').prepend(in_group);
    }
    
    function g_chkOneClick(elem) {
        var input = $(elem).parents('tr').find('input[type="text"]');
        var other = $('input[data-control="chk_one"]').not(elem);
        
        input.attr('name', 'right_one');
        input.parent('div').toggleClass('has-success');

        other.each(function() {
            if($(this)[0].checked) {
                $(this).prop('checked', false);
                g_mark_wrong_one($(this));
            }
        })
    }
    
    function g_mark_wrong_one(chbx_element) {
        var input = chbx_element.parents('tr').find('input[type="text"]');
        
        input.attr('name', 'wrong_one[]');
        input.parent('div').removeClass('has-success');
    }
JS;
echo $script;