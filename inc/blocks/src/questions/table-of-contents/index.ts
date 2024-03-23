import { registerBlockType } from '@wordpress/blocks';
import metadata from './block.json';
import { Edit } from './edit';
import './style.scss';

registerBlockType(metadata.name, {
	...metadata,
	icon: 'editor-indent',
	edit: Edit,
	save: () => null,
});
