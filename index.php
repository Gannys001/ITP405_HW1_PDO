<?php
    $pdo = new PDO('sqlite:chinook.db');
    $sql = 'SELECT * FROM playlists';

    $statement = $pdo->prepare($sql);

    $statement->execute();
    $playlists = $statement->fetchAll(PDO::FETCH_OBJ);  
?>



<table>
    <thead>
        <tr>
            <th>Playlist</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($playlists as $playlist) : ?>
            <tr>
                <td>
                    <a href="tracks.php?playlist=<?php echo $playlist->PlaylistId ?>">
                        <?php echo $playlist->Name ?> 
                    </a> 
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>