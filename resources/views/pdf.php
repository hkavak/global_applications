<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
            <?php foreach (Session::get('listArray') as $object): ?>
                <?php if (Session::get('currentId') == $object->application_id && Session::has('currentId')): ?>
                    <?php echo e($object->first_name); ?> <?php echo e($object->last_name); ?> - Personal Information
                <?php endif; ?>
            <?php endforeach; ?></title>
    </head>
    <body>
        <div>
            <?php if (Session::has('listArray')): ?>
                <h4>Personal information</h4>
                <?php foreach (Session::get('listArray') as $object): ?>
                    <?php if (Session::get('currentId') == $object->application_id && Session::has('currentId')): ?>
                        <p>Applicant name: <?php echo e($object->first_name); ?> <?php echo e($object->last_name); ?></p>
                        <p>Social security number: <?php echo e($object->ssn); ?></p>
                        <p>Email: <?php echo e($object->email); ?></p>
                        <p>Submission date: <?php echo e($object->submissionDate); ?></p>
                        <p>Status: <?php echo e($object->status); ?></p>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div>
            <?php if (Session::has('competenceArray')): ?>
                <h4>Personal Competences and years of work</h4>
                <?php foreach (Session::get('competenceArray') as $object): ?>
                    <p>Worked with <?php echo e($object->competence); ?> for <?php echo e($object->years); ?> years</p>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div>
            <?php if (Session::has('periodArray')): ?>
                <h4>Can only work on these periods</h4>
                <?php foreach (Session::get('periodArray') as $object): ?>
                    <p>Can work from <?php echo e($object->from_date); ?> to <?php echo e($object->to_date); ?></p>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </body>
</html>