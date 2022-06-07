import { cleanup, render } from '@testing-library/react';
import renderer from 'react-test-renderer';
import AutocompleteBAN from '../components/Farm/Positions/AutocompleteBAN';

describe('AutocompleteBAN components', () => {

    afterEach(cleanup);

    it('renders correctly', () => {
        const tree = renderer.create(<AutocompleteBAN />).toJSON();
        expect(tree).toMatchSnapshot();
    });

    it('It\'s different after click', () => {
        const { getByText } = render(<AutocompleteBAN />);
        getByText.find('input').simulate('click');
        expect(getByText).not.toMatchSnapshot();
    });

});

describe('AutocompleteBAN components', () => {

    afterEach(cleanup);

    //try to write an address in the input field and check if the autocomplete is working
    it('renders correctly', () => {
        const { getByTestId } = render(<AutocompleteBAN />);
        const input = document.querySelector('input');
        input.value = '1 rue de la paix';
        expect(input.value).toBe('1 rue de la paix');
    });

});
