/**
 * External dependencies
 */
import ServerSideRender from '@wordpress/server-side-render';
import { Disabled, Placeholder } from '@wordpress/components';
import type { IconType } from '@wordpress/components';

type Props = {
	attributes: Object;
	description: string;
	name: string;
	icon: IconType;
	title: string;
};

/**
 * Component displaying the categories as dropdown or list.
 *
 * @param {Object}   props             Incoming props for the component.
 * @param {Object}   props.attributes  Incoming block attributes.
 * @param {IconType} props.icon
 * @param {string}   props.description
 * @param {string}   props.title
 * @param {string}   props.name
 */
export const ServerSideRenderComponent = ({
	attributes,
	description,
	title,
	name,
	icon,
}: Props) => {
	const EmptyPlaceholder = () => (
		<Placeholder icon={icon} label={title}>
			{description}
		</Placeholder>
	);

	return (
		<Disabled>
			<ServerSideRender
				block={name}
				attributes={attributes}
				EmptyResponsePlaceholder={EmptyPlaceholder}
			/>
		</Disabled>
	);
};
