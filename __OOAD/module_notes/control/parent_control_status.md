# Parent Control Status

## Requirments

- Parent Control Status
    > If the control is parent control then its control status will depend on its children and can't do an audit on it
    <br> * All child controls are `Not Applicable` then the parent control status will be `Not Applicable`
    <br> * All child controls have the same control status then the parent control status will have the same control status
    <br> * All child controls have a mix of control status than the parent control status will be `Partially Implemented`