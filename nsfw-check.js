import nsfw from 'nsfwjs';
import * as tf from '@tensorflow/tfjs-node';
import fs from 'fs';

async function checkImage(imagePath) {
    const model = await nsfw.load();
    const imageBuffer = fs.readFileSync(imagePath);
    const image = await tf.node.decodeImage(imageBuffer, 3);

    const predictions = await model.classify(image);
    image.dispose();

    console.log(JSON.stringify(predictions));
}

const imagePath = process.argv[2];
checkImage(imagePath);
