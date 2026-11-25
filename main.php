<?php

// Reproduce the JSONL comparison from the review of WordPress Core PR #16204.

if ( $argc !== 2 || ! is_file( $argv[1] ) || ! is_readable( $argv[1] ) ) {
	fwrite( STDERR, "Usage: php main.php /path/to/upstream-diff.php\n" );
	exit( 1 );
}

function check_diff( string $script, array $arguments, int $expectedExit, string $expectedText ): void {
	$command = implode( ' ', array_map( 'escapeshellarg', array_merge( [ PHP_BINARY, $script ], $arguments ) ) );
	exec( $command . ' 2>&1', $lines, $exit );
	$output = implode( "\n", $lines );

	if ( $exit !== $expectedExit || strpos( $output, $expectedText ) === false ) {
		throw new RuntimeException( "Unexpected result (exit $exit):\n$output" );
	}

	echo "$output\nExit code: $exit\n\n";
}

$directory = sys_get_temp_dir() . '/wp-core-66802-' . bin2hex( random_bytes( 8 ) );
if ( ! mkdir( $directory, 0700 ) ) {
	fwrite( STDERR, "Could not create the temporary directory.\n" );
	exit( 1 );
}

$before = $directory . '/before.jsonl';
$after = $directory . '/after.jsonl';
$exit = 0;

try {
	$snapshot = [
		'pid'   => 1,
		'point' => 'class_start',
		'id'    => 'Demo',
		'state' => [],
	];

	$changed = $snapshot;
	$changed['state']['global|example'] = [ '1', '1' ];

	foreach ( [ $before => $snapshot, $after => $changed ] as $path => $sample ) {
		$json = json_encode( $sample, JSON_THROW_ON_ERROR ) . "\n";
		if ( file_put_contents( $path, $json ) !== strlen( $json ) ) {
			throw new RuntimeException( 'Could not write the JSONL fixture.' );
		}
	}

	echo "Two-run comparison\n";
	check_diff( $argv[1], [ $before, $after, 'Demo' ], 2, 'global|example' );

	echo "Single-run analysis\n";
	check_diff( $argv[1], [ $before ], 1, 'Incomplete run' );

	echo "Both results matched the published review.\n";
} catch ( RuntimeException | JsonException $error ) {
	fwrite( STDERR, $error->getMessage() . "\n" );
	$exit = 1;
} finally {
	foreach ( [ $before, $after ] as $path ) {
		if ( is_file( $path ) ) {
			unlink( $path );
		}
	}
	rmdir( $directory );
}

exit( $exit );
