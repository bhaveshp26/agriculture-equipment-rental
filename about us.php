<?php
// About Us content
$company_name = "Your Company Name";
$mission = "Empower farmers by providing easy, affordable, and timely access to high-quality machinery and tools, ensuring they can maximize productivity and yields without the burden of ownership costs.";
$vision = "We envision a future where every farmer, regardless of their size or location, has the resources they need to cultivate their land efficiently and sustainably.";
$what_we_offer = [
    "Cost-Effective Solutions" => "Renting equipment is a fraction of the cost of purchasing, allowing farmers to allocate resources more effectively.",
    "Flexible Rentals" => "Our platform offers flexible rental periods to suit your farming schedule, whether you need equipment for a day, a week, or a season.",
    "Quality Assurance" => "We partner with trusted equipment owners to ensure that all machinery is well-maintained and ready for use.",
    "Easy Access" => "Our user-friendly platform makes it simple to browse, book, and manage equipment rentals, saving you time and effort."
];
$our_story = "Founded by a group of agricultural enthusiasts, $company_name was born out of a desire to solve the common challenges faced by farmers—limited access to essential equipment and the high costs of ownership. Recognizing the potential of a shared economy in agriculture, we created a platform that brings together equipment owners and farmers, creating a win-win situation for all.";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - <?php echo $company_name; ?></title>
</head>
<body>
    <h1>About Us</h1>
    <p>Welcome to <?php echo $company_name; ?>, the leading platform dedicated to revolutionizing the way farmers access essential agricultural equipment.</p>
    
    <h2>Our Mission</h2>
    <p><?php echo $mission; ?></p>

    <h2>Our Vision</h2>
    <p><?php echo $vision; ?></p>

    <h2>What We Offer</h2>
    <ul>
        <?php
        foreach ($what_we_offer as $title => $description) {
            echo "<li><strong>$title:</strong> $description</li>";
        }
        ?>
    </ul>

    <h2>Our Story</h2>
    <p><?php echo $our_story; ?></p>

    <h2>Join Us</h2>
    <p>Whether you’re a farmer looking to enhance your operations or an equipment owner seeking to maximize the utilization of your assets, <?php echo $company_name; ?> is here to help. Join our community today and take the first step toward a more sustainable and productive agricultural future.</p>

</body>
</html>