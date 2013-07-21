<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
<script src="js/galleria/galleria-1.2.9.min.js"></script>

<style>
    #galleria { 
    	width: 700px; 
    	height: 400px; 
    	background: #000 
   	}
</style>

<div id="galleria"></div>
<script>
var data = [
    {
        thumb: 'thumb.jpg',
        image: 'image.jpg',
        big: 'big.jpg',
        title: 'My title',
        description: 'My description',
        link: 'http://my.destination.com',
        layer: '<div><h2>This image is gr8</h2><p>And this text will be on top of the image</p>'
    },
    {
        video: 'http://www.youtube.com/watch?v=GCZrz8siv4Q',
        title: 'My second title',
        description: 'My second description'
    },
    {
        thumb: 'thumb.jpg',
        iframe: 'http://aino.com',
        title: 'My third title'
    }
];
Galleria.run('#galleria', {
    dataSource: data
});
</script>