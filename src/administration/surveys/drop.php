<?php if (!isset($_SESSION)) { session_start(); }
require $_SERVER['DOCUMENT_ROOT'] . '/src/db/connect.php';
$login=$_SESSION["user"];
$result = $pdo->query("SELECT * FROM `surveys` where `login`='$login'");
while($item = $result->fetch()) { ?>                          
                                <a class="dropdown-item" 
                                    href="/surveys.php?id=<?php echo $item['id'] ?>&title=<?php echo $item['title'] ?>">
                                    <?php echo $item['title'] ?>
                                </a>
<?php }?>

