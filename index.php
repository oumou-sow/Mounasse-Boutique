<?php
require_once __DIR__ . '/db.php';

// Récupération des produits depuis la table `produits`
// Colonnes attendues : nom, prix, images-url
$sql = "SELECT nom, prix, `images-url` FROM produits";
$stmt = $pdo->query($sql);
$products = $stmt->fetchAll();
?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Mounasse Boutique</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <header class="topbar">
    <div class="brand" aria-label="Mounasse Boutique">
      <div class="brand-top">MOUNASSE BOUTIQUE</div>

      <div class="monogram" aria-hidden="true">
        <span class="letter m">M</span>
        <span class="letter b">B</span>
      </div>

      <div class="brand-bottom">Maroquinerie • Voyage • Business • Sénégal</div>
    </div>
  </header>

  <section class="hero">
    <div class="welcome-slider" aria-label="Messages d'accueil">
      <div class="welcome-overlay" aria-hidden="true"></div>
      <div class="welcome-track" role="status" aria-live="polite">
        <div class="welcome-slide">Bienvenue chez Mounasse Boutique</div>
        <div class="welcome-slide">Découvrez notre Maroquinerie de Luxe</div>
        <div class="welcome-slide">Livraison disponible partout au Sénégal</div>
      </div>
    </div>
  </section>

  <main class="container">
    <div class="product-grid" id="productGrid" aria-label="Produits">
      <?php foreach ($products as $product): ?>
        <?php
          $nom = htmlspecialchars($product['nom'] ?? '', ENT_QUOTES, 'UTF-8');
          $prixRaw = $product['prix'] ?? 0;
          $prix = number_format((float)$prixRaw, 0, ',', ' ') . ' FCFA';
          $prix = htmlspecialchars($prix, ENT_QUOTES, 'UTF-8');

          $imageFile = htmlspecialchars($product['images-url'] ?? '', ENT_QUOTES, 'UTF-8');
          $src = 'images/' . $imageFile;
        ?>

        <article class="product-card" data-name="<?= $nom ?>" data-whatsapp="<?= $nom ?>">
          <div class="product-title"><?= $nom ?></div>
          <div class="product-price"><?= $prix ?></div>

          <div class="product-visual" aria-hidden="true">
            <img
              class="product-image"
              src="<?= $src ?>"
              alt="<?= $nom ?>"
              loading="lazy"
            />
          </div>

          <a class="btn btn-whatsapp" href="#" data-action="whatsapp">Commander</a>
        </article>
      <?php endforeach; ?>
    </div>
  </main>

  <footer class="footer">
    <div class="footer-inner">
      <span>© <?php echo date('Y'); ?> Mounasse Boutique</span>
      <span class="sep">•</span>
      <span>Design noir & or luxueux</span>
    </div>
  </footer>

  <script>
    // WhatsApp (à personnaliser)
    const WHATSAPP_PHONE = '221768048390'; // ex: 2126... (sans +)

    function buildWhatsAppLink(text) {
      const encoded = encodeURIComponent(text);
      return `https://wa.me/${WHATSAPP_PHONE}?text=${encoded}`;
    }

    document.addEventListener('click', (e) => {
      const btn = e.target.closest('[data-action="whatsapp"]');
      if (!btn) return;

      e.preventDefault();
      const card = btn.closest('.product-card');
      const name = card?.dataset?.whatsapp || card?.dataset?.name || 'Produit';

      const msg = `Bonjour, je voudrais commander : ${name}. Merci.`;
      window.open(buildWhatsAppLink(msg), '_blank');
    });
  </script>

  <script src="script.js"></script>
</body>
</html>

