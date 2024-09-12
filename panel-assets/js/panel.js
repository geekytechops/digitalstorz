function printContent(entryId) {
    // Create a new window
    var printWindow = window.open('', '', 'height=600,width=800');

    // Fetch the content from print-content.php
    fetch('print-content.php?entry_id=' + entryId)
        .then(response => response.text())
        .then(data => {
            // Write the fetched content to the new window
            printWindow.document.open();
            printWindow.document.write('<html><head><title>Print Content</title></head><body>');
            printWindow.document.write(data);
            printWindow.document.write('</body></html>');
            printWindow.document.close();

            // Trigger the print dialog
            printWindow.print();

            // Close the print window after printing
            printWindow.onafterprint = function() {
                printWindow.close();
                // Redirect to another page after printing
                window.location.href = 'your-redirect-page.php';
            };
        })
        .catch(error => console.error('Error fetching content:', error));
}

const createOtherStaff = (name,mobile) =>{
    $.ajax({
        type:'post',
        url:'manage-update.php',
        data:{name:name,mobile:mobile,formName:'addOtherStaff'},
        success:function(data){        
            $('.toast-success').css('left','unset');   
            $('.toast-success').css('right','2rem');
            $('.toast-success .toast-body').html(JSON.parse(data).message);
         setTimeout(() => {
             $('.toast-success').css('left','100%');   
             $('.toast-success').css('right','unset');   
         }, 2000);

         if(JSON.parse(data).status=='success'){
            $('#otherStaffModel').modal('hide'); 
            location.reload();      
         }else{
            $('#otherStaffModel').modal('show');      
         }

        }
    })
}

const addLockData = () =>{

        var selectedPattern = p.getPattern();                
        $('#patternlock_data').val(selectedPattern);
        if(isNaN(selectedPattern)){
            alert('No pattern drawn');
            return false;
        }

    $('#patternModel').modal('hide');
}


$('#vertical-menu-btn').click(function(){
    $('.vertical-menu').toggle();
})

// const toggleScreenlock = () =>{			
//     if($('input[name="screenlock_types"]:checked').val()==0){
//         $('#pin_lock').hide();
//         $('#pattern_lock').css('display','flex');
//     }else{
//         $('#pin_lock').show();
//         $('#pattern_lock').hide();
//     }
// }