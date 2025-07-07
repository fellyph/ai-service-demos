import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
import { useSelect } from '@wordpress/data';
import { store as blockEditorStore } from '@wordpress/block-editor';
import { serialize } from '@wordpress/blocks';
import { Button } from '@wordpress/components';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @param {Object}   props               Properties passed to the function.
 * @param {Object}   props.attributes    Available block attributes.
 * @param {Function} props.setAttributes Function that updates individual attributes.
 *
 * @return {Element} Element to render.
 */
export default function Edit( { attributes, setAttributes } ) {
	const blockProps = useBlockProps();
	const { aiGeneratedText } = attributes;
	
	// Add safety check for aiServices
	const aiServices = window.aiServices;
	const { enums, helpers, store: aiStore } = aiServices?.ai || {};

	const service = useSelect( ( select ) => {
		if ( !aiStore ) return null;
		return select( aiStore ).getAvailableServices( enums?.SERVICE_ARGS?.capabilities );
	} );
	
	const { postContent } = useSelect( ( select ) => {
		const content = new DOMParser().parseFromString(
			serialize( select( blockEditorStore ).getBlocks() ),
			'text/html'
		).body.textContent || '';
		return {
			postContent: content,
		};
	} );

	const handleClick = async () => {
		if ( !aiServices?.ai ) {
			console.error( 'AI services not available' );
			return;
		}

		try {
			const newExcerpt = await service.generateText(
				`${ __(
					'Summarize the following text in full sentences in less than 300 characters:',
					'write-excerpt-plugin'
				)} ${ postContent }`,
				{ feature: 'write-excerpt-plugin' }
			);

			const result = helpers.getTextFromContents(
				helpers.getCandidateContents( newExcerpt )
			).replaceAll( '\n\n\n\n', '\n\n' );

			// Store the result in a block attribute
			setAttributes( { aiGeneratedText: result } );
			
		} catch ( error ) {
			console.error( error );
			return;
		}
	};

	return (
		<p { ...blockProps }>
			{ __(
				( service ) ? ( aiGeneratedText || 'Say hello to the AI!' ) : 'No AI services available',
				'example-interactive-typescript'
			) }
			<Button onClick={ handleClick }>
				{ __( 'Generate Text', 'example-interactive-typescript' ) }
			</Button>
		</p>
	);
}
