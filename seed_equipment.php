<?php
// Run this file ONCE to seed default equipment: http://localhost/agriculture/seed_equipment.php
include_once("connection.php");

$equipment = [
    ['1',  '5 Tine Duck Foot Cultivator',   'Cultivation',    '500',  'Available', 'images/inst1.webp',          'Tractor-operated implement for primary tillage operations and ploughing fields.'],
    ['2',  'Mounted Offset Disc Harrow',     'Soil Prep',      '600',  'Available', 'images/inst3.png',           'Agriculture tool used to prepare soil, break clods and control weeds effectively.'],
    ['3',  'Agriculture Rake',               'Hand Tools',     '150',  'Available', 'images/inst2.jfif',          'Garden and farm tool used to gather loose material like leaves, hay and debris.'],
    ['4',  'Tractor 50 HP',                  'Tractor',        '2500', 'Available', 'images/tractor-50.jpg',      'Powerful 50 HP tractor suitable for heavy field operations and large farm areas.'],
    ['5',  'Tractor 74 HP',                  'Tractor',        '3500', 'Available', 'images/tractor-74.jpg',      'High-performance 74 HP tractor for demanding agricultural tasks and large fields.'],
    ['6',  'Tractor Trolley',                'Transport',      '800',  'Available', 'images/tractor-trolley.jpg', 'Heavy-duty tractor trolley for transporting crops, fertilizers and farm produce.'],
    ['7',  'Power Tiller',                   'Tilling',        '900',  'Available', 'images/Power-Tiller.jpg',    'Compact power tiller for small to medium farms, ideal for paddy and vegetable fields.'],
    ['8',  'Seed Drill',                     'Seeding',        '700',  'Available', 'images/seeder.png',          'Precision seed drill for uniform sowing of seeds at correct depth and spacing.'],
    ['9',  'Hand Pump Sprayer',              'Spraying',       '200',  'Available', 'images/spray-hand-pump.jpg', 'Manual hand pump sprayer for pesticide and fertilizer application on crops.'],
    ['10', 'Plough',                         'Soil Prep',      '450',  'Available', 'images/plough.png',          'Traditional plough for turning and loosening soil before sowing season.'],
    ['11', 'JCB Excavator',                  'Excavation',     '5000', 'Available', 'images/jcb.jpg',             'Heavy JCB excavator for land levelling, pond digging and large-scale earthwork.'],
    ['12', 'Rotavator',                      'Tilling',        '1100', 'Available', 'images/inst1.webp',          'Rotary tiller that breaks and mixes soil thoroughly for better seedbed preparation.'],
    ['13', 'Paddy Thresher',                 'Harvesting',     '1300', 'Available', 'images/inst3.png',           'Efficient paddy thresher to separate grain from straw quickly after harvesting.'],
    ['14', 'Maize Sheller',                  'Post-Harvest',   '600',  'Available', 'images/inst2.jfif',          'Maize sheller machine for fast and clean removal of kernels from corn cobs.'],
    ['15', 'Water Pump (Diesel)',             'Irrigation',     '750',  'Available', 'images/inst1.webp',          'Diesel-powered water pump for efficient irrigation of fields and water transfer.'],
    ['16', 'Sugarcane Cutter',               'Harvesting',     '950',  'Available', 'images/inst3.png',           'Mechanical sugarcane cutter for faster harvesting with reduced manual labour.'],
    ['17', 'Fertilizer Spreader',            'Fertilization',  '550',  'Available', 'images/inst2.jfif',          'Tractor-mounted fertilizer spreader for uniform distribution across large fields.'],
    ['18', 'Combine Harvester',              'Harvesting',     '8000', 'Available', 'images/inst1.webp',          'Modern combine harvester for simultaneous cutting, threshing and cleaning of crops.'],
];

$inserted = 0;
$skipped  = 0;

foreach ($equipment as $eq) {
    // Check if eq_id already exists
    $check = mysqli_prepare($con, "SELECT eq_id FROM equipments WHERE eq_id = ?");
    mysqli_stmt_bind_param($check, "s", $eq[0]);
    mysqli_stmt_execute($check);
    mysqli_stmt_store_result($check);
    if (mysqli_stmt_num_rows($check) > 0) {
        $skipped++;
        mysqli_stmt_close($check);
        continue;
    }
    mysqli_stmt_close($check);

    $stmt = mysqli_prepare($con,
        "INSERT INTO equipments (eq_id, name, eq_type, rent_price, status, eq_img, description) VALUES (?,?,?,?,?,?,?)"
    );
    mysqli_stmt_bind_param($stmt, "sssssss", $eq[0], $eq[1], $eq[2], $eq[3], $eq[4], $eq[5], $eq[6]);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $inserted++;
}

mysqli_close($con);
echo "<div style='font-family:sans-serif; max-width:500px; margin:50px auto; padding:30px; background:#e8f5e9; border-radius:12px; border:2px solid #4caf50;'>";
echo "<h3 style='color:#1a6b1a;'>✅ Equipment Seeded</h3>";
echo "<p><b>Inserted:</b> $inserted</p>";
echo "<p><b>Skipped (already exist):</b> $skipped</p>";
echo "<p><a href='view_equipment.php' style='color:#1a6b1a; font-weight:600;'>→ View Equipment List</a></p>";
echo "<p><a href='user_view_eq.php' style='color:#1a6b1a; font-weight:600;'>→ View as User</a></p>";
echo "</div>";
?>
