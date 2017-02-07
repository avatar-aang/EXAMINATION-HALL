function get_options_field(noptions)
{
     var action ='get_options_field.php';
     var form_data = {
     no_options:noptions
   };
   $.ajax({
     type:"POST",
     url: action,
     data: form_data,
	 async: false,
     dataType: 'json',
     complete:function(response)
     {
       $("#options").html(response);
     }
   });
}
function submit_code()
{
	var action="http://api.hackerrank.com/checker/submission.json";
	var lang=$('#s_language').val();
    var source=$('#text_editor').html();
	var test='["fefef"]';
	//var obj=JSON.parse(test);
	var key="hackerrank|854609-971|7b6881d5bab41d25ae6e8093f41f34e32v8b8b91"
	var form_data={
		source: source,
		lang: lang,
		testcase: test,
		wait:true,
		api_key: key,
		format:'json'
	}
	$.ajax({
		type:"POST",
		url:action,
		data:form_data,
		success:function(response)
	    {
			//var sd=JSON.stringify(response);
			alert(response);
		}
	});
}

function obtainQuestion(questionId,typeId)
{
	var action="obtain_question.php";
	var form_data={
		question_id : questionId,
		type_id : typeId
	}
	$.ajax({
		type:"POST",
		url:action,
		data:form_data,
		success:function(response)
	    {
			$("#question_container").html(response);
		}
	});
}

function saveAnswer(questionId,typeId)
{
	var action="save_answer.php";
	var answer;
	if(typeId==1)
	{
		answer=$('#subjective_answer').val();
	}
	else if(typeId==2)
	{
		answer=$('input[name=mcq_answer]:checked').val();
	}
	else if(typeId==3)
	{
		answer=$('#coding_answer').val();
	}
	else;
	var form_data={
		question_id : questionId,
		type_id : typeId,
		answer : answer
	}
	$.ajax({
		type:"POST",
		url:action,
		data:form_data,
		success:function(response)
	    {
			$("#status_save").html(response);
		}
	});
}
function changeSubMarksInc(current,max)
{
	if(parseInt(current)>parseInt(max))
	  	return ;
	if(!isNaN(current.trim()))
	{
		var prev=$("#subjective_marks").html();
	    prev=parseInt(prev)+parseInt(current);
		$("#subjective_marks").html(prev);
	}
}

function insertSubMarks(id,max)
{
	var val=document.getElementById('submarks'+id).value;
	if(parseInt(val)>parseInt(max))
	  	return ;
	var action="insertSubMarks.php";
	var form_data={
		answer_id : id,
		setter_points : val
	}
	$.ajax({
		type:"POST",
		url:action,
		data:form_data,
		success:function(response)
	    {
			if(!isNaN(response))
			{
				var prev=$("#subjective_marks").html();
	            prev=prev-response+parseInt(val);
		        $("#subjective_marks").html(prev);
				var total=$("#total_marks").html();
				total=total-response;
				total=total+parseInt(val);
 				$("#total_marks").html(total);
				alert('saved');
			}
			else
				alert('some error occured');
		}
	});
}
function printDiv(div_id) {
     w=window.open();
     w.document.write($('#'+div_id).html());
     w.print();
     w.close();
}
function save_feedback(user_id,contest_id)
{
	var feedback=$("textarea#feedback").val();
    var action="save_feedback.php";
	var form_data={
		user_id:user_id,
		contest_id:contest_id,
		feedback:feedback
	}
	$.ajax({
		type:"POST",
		url:action,
		data:form_data,
		success:function(response)
	    {
			
		}
	});
}

