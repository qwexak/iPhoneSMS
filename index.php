<?

require __DIR__ . '/vendor/autoload.php';


$db = new SQLite3('base/3d0d7e5fb2ce288813306e4d4636395e047a3d28.db3');
//$db = new SQLite3('base/3d0d7e5fb2ce288813306e4d4636395e047a3d28.mari.db');


if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    $rowid = $_POST['rowid'];
    $query = $db->query("SELECT text, is_from_me, datetime(message.date, 'unixepoch', '+31 years', '+6 hours') as date FROM message WHERE `handle_id` = '{$rowid}'");
    while ($res = $query->fetchArray(SQLITE3_ASSOC)) {
        $msg[] = $res;
    }

    echo json_encode($msg);
} else {
	$query = $db->query("select h.rowid,h.id, count(h.id) as count from message as m join handle as h ON m.handle_id = h.rowid group by h.id");
  
    while ($res = $query->fetchArray(SQLITE3_ASSOC)) {
        $handles[] = $res;
    }
    $loader = new Twig_Loader_Filesystem(__DIR__ . '/templates');
    $twig = new Twig_Environment($loader);
    echo $twig->render('base.twig', array('handles' => $handles));
}

