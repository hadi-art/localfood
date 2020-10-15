// add operator log
function add_operator_log(url,event,module,message,type="post")
{
    $.ajax({
        url:url,
        type:type,
        dataType:"json",
        data:{event:event,module:module,message:message},
        success:function (res) {
            console.log(res);
        }
    });
}
