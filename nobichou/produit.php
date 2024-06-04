<?php
session_start();
require_once 'config.php';

// Vérifie si un produit est déjà dans le panier
function isProductInCart($id) {
    return isset($_SESSION['panier'][$id]);
}

// Traitement de l'ajout au panier
if (isset($_POST['acheter'], $_POST['id'], $_POST['nom'], $_POST['prix'])) {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $prix = $_POST['prix'];

    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = array();
    }

    if (!isset($_SESSION['panier'][$id])) {
        $_SESSION['panier'][$id] = array(
            'nom' => $nom,
            'prix' => $prix
        );
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./Assets/CSS/accueil.css">
    <link rel="stylesheet" href="./Assets/CSS/style.css">
    <link rel="stylesheet" href="./Assets/CSS/produits.css">
    <link rel="stylesheet" href="./Assets/CSS/produit.css">
    <title>Détails du produit</title>
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <section class="product-details">
            <?php
            if(isset($_GET['id'], $_GET['nom'], $_GET['prix'])) {
                $id = $_GET['id'];
                $nom = $_GET['nom'];
                $prix = $_GET['prix'];

                $query_product = "SELECT * FROM produits WHERE id = $id";
                $result_product = $mysqli->query($query_product);
                $row_product = $result_product->fetch_assoc();
            ?>

            <div class="product-details-header">
                <h2 class="product-name"><?php echo $row_product['nom']; ?></h2>
                <p class="product-price"><?php echo $prix; ?> Fr/CFA</p>
            </div>

            <div class="product-details-content">
                <img src="<?php echo $row_product['image']; ?>" alt="<?php echo $row_product['nom']; ?>" class="product-image">
                <div class="prix-desc">
                    <h2>Description</h2>
                    <p class="product-description"><?php echo $row_product['description']; ?></p>
                    <!-- Ajouter au panier -->
            <form id="add-to-cart-form" method="post" action="">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="hidden" name="nom" value="<?php echo $nom; ?>">
                <input type="hidden" name="prix" value="<?php echo $prix; ?>">
                <?php
                if (isProductInCart($id)) {
                    echo '<button type="button" class="btn-added">Ajouté</button>';
                } else {
                    echo '<button type="submit" name="acheter" class="btn-buy">Ajouter au panier</button>';
                }
                ?>
            </form>
                </div>
            </div>

            <?php
            } else {
                echo "<p>Aucun détail de produit trouvé.</p>";
            }
            ?>
        </section>

        <section class="recommended-products">
            <h1 class="">Produits Recommandés</h1>
            <div class="product-grid">
                <?php
                // Requête pour récupérer les produits recommandés (ajustez la requête en fonction de vos critères)
                $query_recommended = "SELECT * FROM produits WHERE id <> $id ORDER BY RAND() LIMIT 4";
                $result_recommended = $mysqli->query($query_recommended);

                while ($row_recommended = $result_recommended->fetch_assoc()) {
                    ?>
                    <div class="product">
                        <img src="<?php echo $row_recommended['image']; ?>" alt="<?php echo $row_recommended['nom']; ?>" width="300" height="300">
                        <h3><?php echo $row_recommended['nom']; ?></h3>
                        <p>Prix : <?php echo $row_recommended['prix']; ?> Fr/CFA</p>
                        <a href="produit.php?id=<?php echo $row_recommended['id']; ?>&nom=<?php echo $row_recommended['nom']; ?>&prix=<?php echo $row_recommended['prix']; ?>" class="btn-buy">Acheter</a>
                    </div>
                    <?php
                }
                ?>
            </div>
        </section>
    </main>

    <?php include 'footer.php'; ?>
    <script src="./Assets/javascript/script.js"></script>
</body>
</html>
