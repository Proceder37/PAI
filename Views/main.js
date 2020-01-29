$('#btn').on('click', () =>{
    $.ajax('script.php', {
        success: data => $('.response').text(JSON.parse(data).response),
        error: () => $('.response').text('Error!')
    });
});