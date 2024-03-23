/**
 * External dependencies
 */
import { useBlockProps } from '@wordpress/block-editor';
import { postCategories } from '@wordpress/icons';

/**
 * Internal dependencies
 */
import metadata from './block.json';
import { ServerSideRenderComponent } from '@components';

/**
 * Component displaying the categories as dropdown or list.
 *
 * @param {Object} props            Incoming props for the component.
 * @param {Object} props.attributes Incoming block attributes.
 */
export const Edit = ({ attributes }) => {
	const blockProps = useBlockProps();

	return (
		<div {...blockProps}>
			<ServerSideRenderComponent
				attributes={attributes}
				description={metadata.description}
				icon={postCategories}
				name={metadata.name}
				title={metadata.title}
			/>
		</div>
	);
};
