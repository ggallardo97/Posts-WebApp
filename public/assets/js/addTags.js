$(document).ready(function(){

    const max_fields = 5;
    let x=1;

    $('#addTag').on('click',()=>{
        if(x<max_fields){
            x++;
            $('<input type="text" name="tags[]" placeholder="Tags"><br>').insertBefore('#addTag');
        }});
});