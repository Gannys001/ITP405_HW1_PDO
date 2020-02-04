<?php 
    if(!isset($_GET['playlist'])){
        header('Location: index.php');
        exit();
    }

    $pdo = new PDO('sqlite:chinook.db');
    $sql = '
    SELECT 
        tracks.Name as trackName,
        albums.title as albumsTitle,
        artists.Name as artistName,
        invoice_items.UnitPrice as price,
        media_types.Name as mediaType,
        genres.name as genre
    FROM playlist_track
    INNER JOIN tracks ON tracks.TrackId = playlist_track.TrackId
    INNER JOIN albums ON tracks.AlbumId = albums.AlbumId
    INNER JOIN artists ON albums.ArtistId = artists.ArtistId
    INNER JOIN invoice_items ON tracks.TrackId = invoice_items.TrackId
    INNER JOIN media_types ON tracks.MediaTypeId = media_types.MediaTypeId
    INNER JOIN genres ON tracks.GenreId = genres.GenreId
    WHERE PlaylistId = ?     
    ';

    $statement = $pdo->prepare($sql);
    $statement->bindParam(1, $_GET['playlist']);
    $statement->execute();
    $tracks = $statement->fetchAll(PDO::FETCH_OBJ);

    $sql1 = 'SELECT Name FROM playlists WHERE PlaylistId = ?';
    $statement = $pdo->prepare($sql1);
    $statement->bindParam(1, $_GET['playlist']);
    $statement->execute();
    $playlistName = $statement->fetchAll(PDO::FETCH_OBJ);
?>

<table>
    <thead>
        <th>Track Name</th>
        <th>Album Title</th>
        <th>Artist Name</th>
        <th>Price</th>
        <th>Media Type</th>
        <th>Genre</th>
    </thead>
    <tbody>
        <?php foreach($tracks as $track) : ?>
            <tr>
                <td><?php echo $track->trackName ?></td>
                <td><?php echo $track->albumsTitle ?></td>
                <td><?php echo $track->artistName ?></td>
                <td><?php echo $track->price ?></td>
                <td><?php echo $track->mediaType ?></td>
                <td><?php echo $track->genre ?></td>
            </tr>
        <?php endforeach ?>
        <?php if (count($tracks) === 0) : ?>
            <tr>
                <td colspan="4">
                    No tracks found for <?php echo $playlistName[0]->Name ?>
                </td>
            </tr>
        <?php endif ?>
    </tbody>
</table>