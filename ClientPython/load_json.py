import argparse
import json
from pathlib import Path

REQUIRED_FIELDS = ("name", "city", "category")


class DataValidationError(ValueError):
    """Raised when place data does not match the expected structure."""


def load_json_file(json_file_path):
    content = json_file_path.read_text(encoding="utf-8")
    data = json.loads(content)

    return data


def validate_place_data(data: object) -> None:
    if not isinstance(data, dict):
        raise DataValidationError("Top-level JSON value must be an object.")

    for field in REQUIRED_FIELDS:
        if field not in data:
            raise DataValidationError(f"Missing required field: {field}")

        value = data[field]

        if not isinstance(value, str):
            raise DataValidationError(f"Field must contain text: {field}")

        if not value.strip():
            raise DataValidationError(f"Field cannot be empty: {field}")


def parse_args() -> argparse.Namespace:
    parser = argparse.ArgumentParser(description="Load and validate JSON site data.")

    parser.add_argument(
        "-f", "--file", type=Path, required=True, help="Path to the JSON data file."
    )

    return parser.parse_args()


def main() -> int:
    args = parse_args()
    json_file_path = args.file

    if not json_file_path.exists():
        print("JSON file not found:", json_file_path)
        return 1

    try:
        data = load_json_file(json_file_path)
    except json.JSONDecodeError as error:
        print("Invalid JSON:", error)
        return 1

    try:
        validate_place_data(data)
    except DataValidationError as error:
        print("Invalid data:", error)
        return 1

    print("Name:", data["name"])
    print("City:", data["city"])
    print("Category:", data["category"])

    return 0


if __name__ == "__main__":
    raise SystemExit(main())
