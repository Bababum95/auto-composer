/**
 * External dependencies
 */
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { postContent } from '@wordpress/icons';
import { PanelBody, SelectControl } from '@wordpress/components';
import { useEffect } from '@wordpress/element';

/**
 * Internal dependencies
 */
import metadata from './block.json';
import { ServerSideRenderComponent } from '@components';

const currentUrl = window.location.origin;

/**
 * Component displaying the categories as dropdown or list.
 *
 * @param {Object} props            Incoming props for the component.
 * @param {Object} props.attributes Incoming block attributes.
 * @param {Function} props.setAttributes
 */
export const Edit = ({ attributes, setAttributes }) => {
	const blockProps = useBlockProps();

	useEffect(() => {
		fetch(`${currentUrl}/wp-json/wp/v2/types/theory-exam-question`)
			.then((response) => {
				if(!response.ok) {
					throw new Error(response.statusText);
				} else {
					return response.json();
				}
			})
			.then((data) => {
				console.log(data);
			})
			.catch((error) => {
				console.log(error);
			})
	}, []);

	return (
		<div {...blockProps}>
			<InspectorControls>
				<PanelBody title="Question Content Settings">
					<SelectControl
						label="Question post"
						value={attributes.postId}
						options={[
							{
								disabled: true,
								label: 'Select a post',
								value: '0',
							},
						]}
					/>
				</PanelBody>
			</InspectorControls>
			<ServerSideRenderComponent
				attributes={attributes}
				description={metadata.description}
				icon={postContent}
				name={metadata.name}
				title={metadata.title}
			/>
		</div>
	);
};
