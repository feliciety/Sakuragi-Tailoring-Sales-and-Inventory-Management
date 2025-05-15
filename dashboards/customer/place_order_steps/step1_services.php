    <?php
    require_once __DIR__ . '../../../../config/db_connect.php';
    require_once __DIR__ . '../../../../config/session_handler.php';

    // Fetch all services with prices from database
    try {
        $query = 'SELECT service_id, service_name, service_description, service_price, service_category FROM services';
        $stmt = $pdo->query($query);
        $dbServices = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log('Error fetching services: ' . $e->getMessage());
        $dbServices = [];
    }

    // Create services array with icons and prices
    $services = [];
    foreach ($dbServices as $service) {
        $icons = [
            'Embroidery' => '🪡',
            'Sublimation' => '🎨',
            'Screen Printing' => '🖨️',
            'Alterations' => '✂️',
            'Patches' => '🧵',
        ];

        $icon = $icons[$service['service_category']] ?? '📌';
        $services[$service['service_name']] = [
            'id' => $service['service_id'],
            'icon' => $icon,
            'price' => $service['service_price'],
            'description' => $service['service_description'],
        ];
    }
    ?>

    <h5 class="mb-3 fw-bold text-center">Step 1: Select a Service</h5>
    <p class="text-muted text-center">Choose the type of service for your custom order. Select one to proceed.</p>

    <div class="row g-4 justify-content-center">
        <?php foreach ($dbServices as $service): ?>
            <div class="col-md-4 col-sm-6">
                <div class="service-card text-center p-4 h-100" 
                    onclick="selectService('<?= $service['service_name'] ?>', this)"
                    data-service-id="<?= $service['service_id'] ?>"
                    data-price="<?= $service['service_price'] ?>"
                    data-category="<?= $service['service_category'] ?>">
                    <div class="service-icon mb-3">
                        <?= $icons[$service['service_category']] ?? '📌' ?>
                    </div>
                    <h6 class="fw-bold mb-2"><?= htmlspecialchars($service['service_name']) ?></h6>
                    <div class="service-price mb-2">₱<?= number_format($service['service_price'], 2) ?></div>
                    <small class="text-muted d-block"><?= htmlspecialchars($service['service_description']) ?></small>
                </div>
            </div>
        <?php endforeach; ?>
    </div>


    <style>
    .service-card {
        background: #ffffff;
        border: 2px solid transparent;
        border-radius: 16px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 14px rgba(11, 92, 249, 0.08);
        cursor: pointer;
        transform: scale(1);
    }

    .service-card:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(11, 92, 249, 0.15);
        border-color: rgba(11, 92, 249, 0.2);
    }

    .service-card.selected {
        border-color: #0B5CF9;
        background: linear-gradient(135deg, #e8f0ff, #ffffff);
        box-shadow: 0 0 0 3px rgba(11, 92, 249, 0.25);
        transform: scale(1.03);
    }

    .service-icon {
        font-size: 48px;
        transition: transform 0.3s ease;
    }

    .service-card:hover .service-icon {
        transform: scale(1.2);
    }

    .service-price {
        color: #0B5CF9;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .selected .service-price {
        color: #0847c7;
    }
    </style>



