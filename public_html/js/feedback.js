window.onload = function() {
  var userName = window.prompt("Please enter your name", "John Smith");
  if (userName != null) {
      alert("Hello "+userName+" This is the Feedback site.You can send Feedback how we can aprove!")
  }
}
document.getElementById('feedbackForm').addEventListener('submit', function(event) {
  event.preventDefault();  // Prevent form from being submitted
    
  var qualityScore = parseInt(document.getElementById('quality').value);
  var speedScore = parseInt(document.getElementById('speed').value);
  var friendlinessScore = parseInt(document.getElementById('friendliness').value);
        
  var ratings = {
    quality: qualityScore,
    speed: speedScore,
    friendliness: friendlinessScore
  };
      
    // Function to calculate average rating
    function calculateAverage(ratings) {
      if (ratings === '') {
        e.preventDefault();
        window.alert(field.name + ' is required!');
        return;
      }
      var total = 0;
      var count = 0;
      for (var category in ratings) {
        total += ratings[category];
        count++;
        
      }
      return total / count;
    }
  
    var averageRating = calculateAverage(ratings);
    
    document.getElementById('result').innerText = "Average rating: " + averageRating.toFixed(1);
  });
  